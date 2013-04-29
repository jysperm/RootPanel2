<?php

/**
 *   该文件包含 lpAuth 的类定义.
 * @package LightPHP
 */

interface lpAuthDrive
{
    static public function succeedCallback();

    static public function auth($user, $passwd);

    static public function login($user, $passwd);

    static public function logout();

    static public function uname();
}