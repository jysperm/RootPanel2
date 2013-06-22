<?php

/**
*   该文件包含 lpApp 的类定义.
*
*   @package LightPHP
*/

trait lpAppRoute
{
    static public function bind($rx, $lambda)
    {
        if(!$rx | preg_match("%{$rx}%u", rawurldecode($_SERVER["REQUEST_URI"])))
        {
            $lambda();
            exit(0);
        }
    }

    static public function goUrl($url, $isExit=false)
    {
        header("Location: {$url}");
        if($isExit)
            exit();
    }
}

class lpApp
{
    use lpAppRoute;

    static public function helloWorld()
    {
        lpFactory::register("lpConfig.lpCfg", function($tag) {
            return new lpConfig;
        });

        /** @var lpConfig $lpCfg */
        $lpCfg = lpFactory::get("lpConfig");
        $lpCfg->load(dirname(__FILE__) . "/../lp-config.php");

        // 设置时区
        date_default_timezone_set($lpCfg["TimeZone"]);

        // 设置运行模式
        if(!defined("lpRunMode"))
            define("lpRunMode", $lpCfg["RunMode"]);

        // 如果PHP版本过低, 显示警告
        if(version_compare(PHP_VERSION, $lpCfg["RecommendedPHPVersion"]) <= 0)
            trigger_error("Please install the newly version of PHP ({$lpCfg["RecommendedPHPVersion"]}+).");

        static::registerErrorHandling();
    }

    static public function registerErrorHandling()
    {
        error_reporting(0);
        if(lpRunMode >= lpDefault)
            error_reporting(E_ERROR | E_PARSE);
        if(lpRunMode >= lpDebug)
            error_reporting(E_ALL | E_STRICT);

        if(lpRunMode <= lpProduction)
        {
            set_exception_handler(function(Exception $exception) {
                die(header("HTTP/1.1 500 Internal Server Error"));
            });
        }
        else
        {
            set_exception_handler(function(Exception $exception) {
                // 暂时我们只打算以纯文本的形式展示信息
                header("Content-Type: text/plant; charset=UTF-8");

                // 头部
                print sprintf(
                    "Exception `%s`: %s\n",
                    get_class($exception),
                    $exception->getMessage()
                );

                // 运行栈
                print "\n^ Call Stack:\n";
                // 从异常对象获取运行栈
                $trace = $exception->getTrace();
                // 如果是 ePHPException 则去除运行栈的第一项，即 error_handler
                if($exception instanceof ePHPException)
                    array_shift($trace);

                // 只有在调试模式才会显示参数的值，其他模式下只显示参数类型
                if(lpRunMode < lpDebug)
                    foreach ($trace as $key => $v)
                        $trace[$key]["args"] = array_map("gettype", $trace[$key]["args"]);

                // 用于打印参数的函数
                $printArgs = function($a) use(&$printArgs)
                {
                    $result = "";
                    foreach($a as $k => $v)
                    {
                        if(is_array($v))
                            $v = "[" . $printArgs($v) . "]";
                        else
                            if(is_string($v) && lpRunMode >= lpDebug)
                                $v = "`{$v}`";
                        if(!is_int($k))
                            $v = "`$k` => $v";

                        $result .= ($result ? ", {$v}" : $v);
                    }
                    return $result;
                };

                // 打印运行栈
                foreach ($trace as $k => $v)
                    print sprintf(
                        "#%s %s%s %s(%s)\n",
                        $k,
                        isset($v["file"]) ? $v["file"] : "",
                        isset($v["line"]) ? "({$v["line"]}):" : "",
                        $v["function"],
                        $printArgs($v["args"])
                    );

                print sprintf(
                    "#  {main}\n  thrown in %s on line %s\n\n",
                    $exception->getFile(),
                    $exception->getLine()
                );

                // 如果当前是调试模式，且异常对象是我们构造的 ePHPException 类型，打印符号表和源代码
                if(lpRunMode >= lpDebug && $exception instanceof lpPHPException)
                {
                    // 用于打印符号表的函数
                    $printVarList = function($a, $tab=0) use(&$printVarList)
                    {
                        $tabs = str_repeat("   ", $tab);
                        foreach($a as $k => $v)
                            if(is_array($v))
                                if(!$v)
                                    print "{$tabs}`{$k}` => []\n";
                                else
                                    print "{$tabs}`{$k}` => [\n" . $printVarList($v, $tab+1) . "{$tabs}]\n";
                            else
                                print "{$tabs}`{$k}` => `{$v}`\n";
                    };

                    print "^ Symbol Table:\n";
                    $printVarList($exception->getVarList());
                }
                if(lpRunMode >= lpDebug)
                {
                    print "\n^ Code:\n";

                    // 显示出错附近行的代码
                    $code = file($exception->getFile());
                    $s = max($exception->getLine()-6, 0);
                    $e = min($exception->getLine()+5, count($code));
                    $code = array_slice($code, $s, $e - $s);

                    // 为代码添加行号
                    $line = $s + 1;
                    foreach($code as &$v)
                    {
                        $l = $line++;
                        if(strlen($l) < 4)
                            $l = str_repeat(" ", 4-strlen($l)) . $l;
                        if($exception->getLine() == $l)
                            $v = "{$l}->{$v}";
                        else
                            $v = "{$l}  {$v}";
                    }

                    print implode("", $code);
                }
            });
        }
    }

    static public function registerShortFunc()
    {
        function c($k)
        {
            /** @var lpConfig $config */
            $config = lpFactory::get("lpConfig");
            return $config->get($k);
        }

        function l()
        {
            /** @var lpLocale $data */
            $data = lpFactory::get("lpLocale");
            return $data->data();
        }

        function f($name, $tag = null)
        {
            return lpFactory::get($name, $tag);
        }
    }
}

/**
 *   默认路由分发器.
 *
 *   该函数实现:
 *   将URL以斜杠划分成若干部分, 以第一个部分为类名创建处理器实例, 调用它的第二个部分指定的函数名,
 *   并将剩余的部分作为参数.
 *
 *   例如请求URL是 /user/show/jybox
 *   那么将会创建user类的一个实例, 以jybox为参数, 调用它的show函数.
 *
 *   你需要通过这样的方式在你的应用中启用该分发器:
 *
 *       lpApp::bindLambda(null, lpApp::$defaultFilter);
 */

class lpDefaultFilter
{
    /**
     *   默认处理器.
     *
     *   这里指定的默认的处理器, 通常是应用首页.
     */
    private $defaultHandlerName;

    /*
     *  处理器类名前缀.
     */
    private $classNameHandler;

    public function __construct($defaultHandlerName, $classNameHandler)
    {
        $this->defaultHandlerName = $defaultHandlerName;
        $this->classNameHandler = $classNameHandler;
    }

    public function __invoke()
    {
        $queryStr = isset($_SERVER["QUERY_STRING"])?$_SERVER["QUERY_STRING"]:"";
        if($queryStr)
            $queryStr = "?{$queryStr}";
        $url = substr($_SERVER["REQUEST_URI"], 0, strlen($_SERVER["REQUEST_URI"]) - strlen($queryStr));

        $args = array_filter(explode("/", $url));

        if(count($args) > 0)
        {
            $hander = $this->classNameHandler->procClass(array_values($args)[0]);
            $hander = new $hander;
            array_shift($args);
        }
        else
        {
            $hander = new $this->defaultHandlerName;
        }

        if(!is_subclass_of($hander, "lpHandler"))
            trigger_error("is not a subclass of lpHander");

        if(count($args) > 0)
        {
            $funcName = $this->classNameHandler->procFunction($args[0]);
            array_shift($args);
            call_user_func_array([$hander, $funcName], $args);
        }
        else
        {
            $hander();
        }
    }
}

class lpDefaultHandlerNameFilter
{
    /*
     *  处理器类名前缀.
     */
    private $handlerPerfix;

    public function __construct($handlerPerfix="")
    {
        $this->handlerPerfix = $handlerPerfix;
    }

    public function procClass($name)
    {
        $parts = array_filter(explode("-", $name));

        foreach($parts as &$word)
            $word = strtoupper(substr($word, 0, 1)) . substr($word, 1);

        $class = $this->handlerPerfix . implode("", $parts) . "Handler";
        return $class;
    }

    public function procFunction($name)
    {
        return str_replace("-", "", $name);
    }
}