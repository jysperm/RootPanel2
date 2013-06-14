<?php

/**
*   该文件用于载入LightPHP库.
*
*   只需包含该文件, 即可使用LightPHP的功能.
*   该文件会:
*
*   * 定义常量 lpStartTime 和 lpInLightPHP
*   * 注册默认 autoload 函数, 以便自动加载 LightPHP 的组件
*   * 读入配置文件
*   * 注册默认错误处理函数, 在出现错误时抛出异常
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
 *  用于供其他文件判断请求是否是由正确入口进入的.
 *
 *  建议在其他文件开头添加下面一行代码, 以拒绝来自非正确入口的请求:
 *  defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));
*/
const lpInLightPHP = true;

/**
 *   该函数用于加载 $name 所指定的类.
 *
 *   该函数只适用于LightPHP中的类, 内部维护了一份类名与文件的对应表(因为LightPHP中一个文件中可能存在多个类).
 *
 *   如果你希望手动加载 LightPHP 中的类, 则可以手动调用该函数.
 *   值得注意的是, 该文件只适用于自动包含类, 而不适用于自动包含函数, 如果需要包含函数, 请先确认函数所属的文件, 再以所属的文件名(不含扩展名)包含为参数调用该函数.
 *
 *   该函数会通过 spl_autoload_register 注册到 autoload 函数栈, 如果你有自己的 __autoload 函数, 请使用手动使用 spl_autoload_register 函数重新注册它, 否则它不会工作.
 *   请参见PHP的文档: http://www.php.net/manual/zh/function.spl-autoload-register.php
 *
 *   @param string $name 要加载的类名
 *
 *   @retutn void
 */

function lpLoader($name)
{
    if(class_exists($name, false))
        return;

    $lpROOT = dirname(__FILE__);

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

// 加载配置文件

lpFactory::register("lpConfig.lpCfg", function($tag) {
    return new lpConfig;
});

/** @var $lpCfg lpConfig */
$lpCfg = lpFactory::get("lpConfig.lpCfg");
$lpCfg->load(dirname(__FILE__) . "/lp-config.php");

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
 *   @throws ErrorException
 */

class PHPException extends Exception
{
    protected $severity;
    protected $varList;

    public function  __construct($message = "", $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, Exception $previous = null, $varList = [])
    {
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
        $this->varList = $varList;

        parent::__construct($message, $code, $previous);
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getVarList()
    {
        return $this->varList;
    }
}

set_error_handler(function($no, $str, $file, $line, $varList)
{
    throw new PHPException($str, 0, $no, $file, $line, null, $varList);
});
