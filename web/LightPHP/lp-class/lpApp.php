<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

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
        lpFactory::register("lpConfig.lpCfg", function() {
            return new lpConfig;
        });

        /** @var lpConfig $lpCfg */
        $lpCfg = lpFactory::get("lpConfig.lpCfg");
        $lpCfg->load(dirname(__FILE__) . "/../lp-config.php");

        // 设置时区
        date_default_timezone_set($lpCfg["lpTimeZone"]);

        // 设置运行模式
        if(!defined("lpRunMode"))
            define("lpRunMode", $lpCfg["lpRunMode"]);

        // 如果PHP版本过低, 显示警告
        if(version_compare(PHP_VERSION, $lpCfg["lpRecommendedPHPVersion"]) <= 0)
            trigger_error("Please install the newly version of PHP ({$lpCfg["lpRecommendedPHPVersion"]}+).");

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
            set_exception_handler(function() {
                while(ob_get_level())
                    ob_end_clean();
                die(header("HTTP/1.1 500 Internal Server Error"));
            });
        }
        else
        {
            set_exception_handler(function(Exception $exception) {
                if(!headers_sent())
                    header("Content-Type: text/plant; charset=UTF-8");

                // 头部
                print sprintf(
                    "\nException `%s`: %s\n",
                    get_class($exception),
                    $exception->getMessage()
                );

                // 运行栈
                print "\n^ Call Stack:\n";
                // 从异常对象获取运行栈
                $trace = $exception->getTrace();
                // 如果是 ePHPException 则去除运行栈的第一项，即 error_handler
                if($exception instanceof lpPHPException)
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
                        {
                            $v = "[" . $printArgs($v) . "]";
                        }
                        else
                        {
                            if(is_string($v) && lpRunMode >= lpDebug)
                                $v = "`{$v}`";
                            else if(is_object($v))
                                $v = get_class($v);
                            else if(!is_int($k))
                                $v = "`$k` => $v";
                        }

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
                        $printArgs(isset($v["args"]) ? $v["args"] : [])
                    );

                print sprintf(
                    "#  {main}\n  thrown in %s on line %s\n\n",
                    $exception->getFile(),
                    $exception->getLine()
                );

                // 如果当前是调试模式，且异常对象是我们构造的 ePHPException 类型，打印符号表
                if(lpRunMode >= lpDebug && $exception instanceof lpPHPException)
                {
                    // 用于打印符号表的函数
                    $printVarList = function($a, $tab=0) use(&$printVarList)
                    {
                        $out = "";
                        $tabs = str_repeat("   ", $tab);
                        foreach($a as $k => $v)
                            if(is_array($v))
                                if(!$v)
                                    $out.= "{$tabs}`{$k}` => []\n";
                                else
                                    $out.= "{$tabs}`{$k}` => [\n" . $printVarList($v, $tab+1) . "{$tabs}]\n";
                            else if(is_object($v))
                                $out.= "{$tabs}`{$k}` => " . get_class($v) ."\n";
                            else if(!is_int($k))
                                $out.= "{$tabs}`{$k}` => {$v}\n";
                            else
                                $out.= "{$tabs}`{$k}` => `{$v}`\n";
                        return $out;
                    };

                    print "^ Symbol Table:\n";
                    print $printVarList($exception->getVarList());
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
        function c($k = null)
        {
            /** @var lpConfig $config */
            $config = lpFactory::get("lpConfig");
            if($k)
                return $config->get($k);
            else
                return $config->data();
        }

        function l($k = null)
        {
            /** @var lpLocale $rpL */
            $rpL = lpFactory::get("lpLocale");
            if($k)
            {
                if(func_num_args() > 1)
                {
                    $args = func_get_args();
                    $format = $rpL->get(array_shift($args));
                    return vsprintf($format, $args);
                }
                return $rpL->get($k);
            }
            return $rpL->data();
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
 *   该函数会对类名和函数名进行修饰：
 *   some-class 修饰为 prefixSomeClassHandler
 *   some-function 修饰为 somefunction
 *
 *
 *   你需要通过这样的方式在你的应用中启用该分发器:
 *
 *       lpApp::bindLambda(null, lpDefaultRouter(["index"]));
 */

function lpDefaultRouter($defaultHandler, $prefix = "")
{
    return function() use($defaultHandler, $prefix)
    {
        $queryStrLen = isset($_SERVER["QUERY_STRING"]) ? strlen($_SERVER["QUERY_STRING"])+1 : 0;
        $url = substr($_SERVER["REQUEST_URI"], 0, strlen($_SERVER["REQUEST_URI"]) - $queryStrLen);
        $params = array_filter(explode("/", $url));

        if(!$params)
            $params = $defaultHandler;

        $handlerName = array_filter(explode("-", array_shift($params)));

        foreach($handlerName as &$word)
            $word = strtoupper(substr($word, 0, 1)) . substr($word, 1);

        $handlerName = $prefix . implode("", $handlerName) . "Handler";

        if(!class_exists($handlerName))
            throw new Exception("class {$handlerName} is not exists");
        if(!is_subclass_of($handlerName, "lpHandler"))
            throw new Exception("{$handlerName} is not a subclass of lpHander");
        $hander = new $handlerName;

        if($params)
            call_user_func_array([$hander, str_replace("-", "", array_shift($params))], $params);
        else
            $hander();
    };
}