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
        /** @var $lpCfg lpConfig */
        $lpCfg = lpFactory::get("lpConfig.lpCfg");

        // 设置时区
        date_default_timezone_set($lpCfg["TimeZone"]);

        // 设置运行模式
        if(!defined("lpRunMode"))
            define("lpRunMode", $lpCfg["RunMode"]);

        // 如果PHP版本过低, 显示警告
        if(version_compare(PHP_VERSION, $lpCfg["RecommendedPHPVersion"]) <= 0)
            trigger_error("Please install the newly version of PHP ({$lpCfg["RecommendedPHPVersion"]}+).");

        // 错误报告
        error_reporting(0);
        if(lpRunMode >= lpDefault)
            error_reporting(E_ERROR | E_PARSE);
        if(lpRunMode >= lpDebug)
            error_reporting(E_ALL | E_STRICT);

        if(lpRunMode >= lpDefault)
        {
            /**
             *   该函数会根据参数, 打印异常信息.
             *
             *   该函数将会被 set_exception_handler() 注册为PHP的默认异常处理程序, 对于未处理的异常显示错误信息.
             *
             *   @param Exception $exception 未处理的异常
             */

            set_exception_handler(function(Exception $exception)
            {
                header("Content-Type: text/plant; charset=UTF-8");

                $traceline = "#%s %s (%s): %s(%s)";
                $msg = "Exception `%s`: %s\nStack trace:\n%s\n  thrown in %s on line %s";

                $trace = $exception->getTrace();

                // 只有在调试模式才会显示参数的值
                if(lpRunMode < lpDebug)
                    foreach ($trace as $key => $stackPoint)
                        $trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);

                $result = [];

                foreach ($trace as $key => $stackPoint)
                    $result[] = sprintf(
                        $traceline,
                        $key,
                        $stackPoint['file'],
                        $stackPoint['line'],
                        $stackPoint['function'],
                        implode(', ', $stackPoint['args'])
                    );

                $result[] = '#' . ++$key . ' {main}';

                $msg = sprintf(
                    $msg,
                    get_class($exception),
                    $exception->getMessage(),
                    implode("\n", $result),
                    $exception->getFile(),
                    $exception->getLine()
                );

                print $msg;

                if(lpRunMode >= lpDebug && $exception instanceof PHPException)
                    print_r($exception->getVarList());
            });
        }
        else
        {
            /**
             *   该函数会根据参数, 打印异常信息.
             *
             *   该函数将会被 set_exception_handler() 注册为PHP的默认异常处理程序, 对于未处理的异常显示错误信息.
             *
             *   @param Exception $exception 未处理的异常
             */

            set_exception_handler(function(Exception $exception)
            {
                header("Content-Type: text/plant; charset=UTF-8");

                die(header("HTTP/1.1 500 Internal Server Error"));
            });
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