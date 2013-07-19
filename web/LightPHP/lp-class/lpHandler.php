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

    public function __construct()
    {
        if(!ob_get_level())
            ob_start();
    }
}

abstract class lpJSONHandler extends lpHandler
{

}
