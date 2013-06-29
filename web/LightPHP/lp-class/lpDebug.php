<?php

/**
*   该文件包含 lpDebug 的类定义.
*
*   @package LightPHP
*/

/**
*   该类用于提高开发过程中的调试效率.
*
*   该类主要提供了以下功能:
*
*   * 打印运行栈
*   * 打印上下文变量的值
*   * 在发生异常时打印以上信息
*   * 打印以上信息及自定义信息到日志
*/

class lpDebug
{
    /**
    *   获取可读的运行栈信息.
    *
    *   该函数会剔除最后一层调用(即该函数自身). 使用该函数即可获得调用处的运行栈现场.
    *
    *   @return string
    */

    public static function printBackTrace()
    {

    }

    static public function log($info, $type, $file=null)
    {
        global $lpROOT;

        if(!$file)
            $file = "{$lpROOT}/debug.log";

        $time = gmdate("Y.m.d H:i:s");

        file_put_contents($file, "{$time} | {$type} | {$info}\n", FILE_APPEND | LOCK_EX);
    }
}