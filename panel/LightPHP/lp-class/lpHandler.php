<?php

/**
*   该文件包含 lpHander 的类定义.
*
*   @package LightPHP
*/

abstract class lpHandler
{
    static protected function isPost()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    static protected function finishRequest()
    {
        if(function_exists("fastcgi_finish_request"))
        {
            session_write_close();
            fastcgi_finish_request();
        }
    }

    public function __construct()
    {
        ob_start();
    }

    public function __destruct()
    {
        ob_end_flush();
    }
}

class lpPage extends lpHandler
{

}

class lpAction extends lpHandler
{

}