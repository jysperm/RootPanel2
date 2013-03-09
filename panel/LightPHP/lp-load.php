<?php

/**
*   该文件用于载入LightPHP库.
*
*   只需包含该文件, 即可使用LightPHP的功能.
*   该文件会:
*
*   * 定义表示LightPHP根目录的变量 $lpROOT
*   * 包含LightPHP的配置文件
*   * 设置 php.ini 中的相关选项
*   * 注册默认 autoload 函数
*   * 注册默认错误处理函数
*   * 注册默认异常处理函数
*
*   @package LightPHP
*/

if(!defined("lpStartTime"))
{
    /**
    *   当前Unix时间戳, 小数, 精确到微秒(如果可能的话).
    *
    *   该常量可用于计算页面执行时间.
    */
    define("lpStartTime", microtime(true));
}

/**
*   LightPHP的根目录(物理路径), 末尾不含斜杠.
*
*   请勿修改该变量, 之所以没有定义常量, 是考虑到变量可以更方便地嵌入到字符串中.
*
*   @final
*   @type string
*/
$lpROOT = dirname(__FILE__);

/**
 *  用于供其他文件判断请求是否是由正确入口进入的.
 *
 *  建议在其他文件开头添加下面一行代码, 以拒绝来自非正确入口的请求:
 *  defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));
*/
define("lpInLightPHP", true);

/**
*   该文件包含了LightPHP所有配置信息.
*
*   @see /lp-main-config.php
*/
require("{$lpROOT}/lp-config.php");

global $lpCfg;

if(!defined("lpMode"))
    define("lpMode", $lpCfg["LightPHP"]["Mode"]);

// 如果PHP版本过低, 显示警告.
if(version_compare(PHP_VERSION, $lpCfg["RecommendedPHPVersion.LightPHP"]) <= 0 && !$lpCfg["PHPVersion.TrunOff.Warning"])
    trigger_error("Please install the newly version of PHP ({$lpCfg["RecommendedPHPVersion.LightPHP"]}+). Or edit `Version.TrunOff.Warning` in /lp-main-config.php ", E_WARNING);

// 如果不是在SAE环境(SAE不支持), 则开启短标记功能.
if(!class_exists("SaeObject",false))
    ini_set("short_open_tag","1");

// 设置时区
date_default_timezone_set($lpCfg["LightPHP"]["TimeZone"]);

/**
*   该函数用于加载 $name 所指定的类.
*
*   该函数只适用于LightPHP中的类, 内部维护了一份类名与文件的对应表(因为LightPHP中一个文件中可能存在多个类).
*
*   如果你希望手动加载 LightPHP 中的类, 则可以手动调用该函数.
*   值得注意的是, 该文件只适用于自动包含类, 而不适用于自动包含函数, 如果需要包含函数, 请先确认函数所属的文件, 再以所属的文件名(不含扩展名)包含为参数调用该函数.
*
*   该函数会通过 spl_autoload_register 注册到 autoload 函数栈, 如果你有自己的 __autoload 函数, 请使用手动使用 spl_autoload_register 函数重新注册它, 否则它不会工作.
*   请参见PHP的文档: http://cn2.php.net/manual/zh/function.spl-autoload-register.php
*
*   @param string $name 要加载的类名
*
*   @retutn void
*/

function lpLoader($name)
{
    global $lpROOT;
    
    if(class_exists($name, false))
        return;

    $map = [
        "lpDefaultFilter" => "lpApp",
        "lpDBInquiryDrive" => "lpDBDrive",
        "lpMySQLDBInquiryDrive" => "lpMySQLDBDrive",
        "lpMongoDBInquiryDrive" => "lpMongoDBDrive",
        "lpMutex" => "lpFileLock"
    ];

    if(in_array($name, array_keys($map)))
        $name = $map[$name];

    $path = "{$lpROOT}/lp-class/{$name}.php";
    if(file_exists($path))
        require_once($path);
}

spl_autoload_register("lpLoader");

/**
*   该函数将会根据参数抛出一个 ErrorException 类型的异常.
*
*   该函数将会被 set_error_handler() 注册为PHP的默认错误处理程序, 将PHP的错误转换为异常抛出.
*   通常你不应该手动调用该函数(你也无法调用匿名函数), 你应当通过抛出异常来表示错误.
*
*   @param int $no 错误的级别
*   @param string $str 错误的描述信息
*   @param string $file 发生错误的文件名(含路径)
*   @param int $line 发生错误的行号
*   @param array $varList 错误发生时的符号表
*
*   @type closures
*   @throws ErrorException
*   @return true
*/

set_error_handler(function($no, $str, $file, $line, $varList)
{
    throw new ErrorException($str, 0, $no, $file, $line);
    return true;
});

if(lpMode == "default")
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
        echo "Uncaught exception: {$exception->getMessage()}\n";
    });
}

