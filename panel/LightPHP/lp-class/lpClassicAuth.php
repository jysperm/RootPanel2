<?php

/**
*   该文件包含 lpHander 的类定义.
*
*   @package LightPHP
*/

class lpClassicAuth extends lpAuthDrive
{
    static public $cbHash = function($data)
    {
        return hash("sha256", $data);
    }

    static public $cbDBHash = function($user, $passwd)
    {
        return self::$cbHash(self::$cbHash($user) . self::$cbHash($passwd));
    }

    static public $cbCookieHash = function($dbPasswd)
    {
        global $lpCfg;

        return self::$cbHash(self::$cbHash($lpCfg["lpClasssicAuth"]["SecurityCode"]) . $dbPasswd);
    }

    static public $cbGetPasswd = function($uname, $conn=null)
    {
        global $lpCfg;
        $cfg = $lpCfg["lpClassicAuth"]["GetPasswd"]["Default"];

        if(!$conn)
            $conn = $lpApp::getDB();
        $q = new lpDBQuery($conn);

        return $q($cfg["table"])->where([$cfg["user"] => $uname])->top()[$cfg["passwd"]];
    }

    static public $cbSucceed = function($user)
    {

    }

    public static function auth($user, $passwd)
    {
        if(isset($passwd["raw"]))
            $passwd = ["db" => slef::$cbDBHash($user, $passwd["raw"])];

        if(isset($passwd["db"]))
        {
            if(slef::$cbGetPasswd($user) == $passwd["db"])
                return true;
            else
                return false;
        }

        if(isset($paaswd["cookie"]))
        {
            if(slef::$cbCookieHash(slef::$cbGetPasswd($user)) == $passwd["cookie"])
                return true;
            else
                return false;
        }

        return false;
    }

    public static function login($user=null, $passwd=null)
    {
        global $lpCfg;
        $cookieName = $lpCfg["lpClassicAuth"]["CookieName"];

        if(!$user || !$passwd)
        {
            if(!$user && isset($_COOKIE[$cookieName["user"]]))
                $user = $_COOKIE[$cookieName["user"]];

            if(!$passwd && isset($_COOKIE[$cookieName["passwd"]))
                $passwd = $_COOKIE[$cookieName["passwd"]];

            if(!$user || !$passwd)
                return false;

            $passwd = ["cookie" => $passwd];
        }

        if(lpAuth::auth($user, $passwd))
        {
            if(isset($passwd["raw"]))
                $passwd = ["db" => self::$cbHash($user, $passwd["raw"])];

            if(isset($passwd["db"]))
                $passwd = ["cookie" => self::$cbCookieHash($user, $passwd["db"])];

            self::$cbSucceed();

            $expire = time() + $lpCfg["lpClassicAuth"]["Limit"];

            setcookie($cookieName["user"], $user, $expire, "/");
            setcookie($cookieName["passwd"], $passwd["cookie"], $expire, "/");

            return true;
        }
        else
        {
            setcookie($cookieName["passwd"], null, time()-1, "/");
            return false;
        }
    }

    public static function uname()
    {
        global $lpCfg;
        $userName = $lpCfg["lpClassicAuth"]["CookieName"]["user"];

        if(isset($_COOKIE[$userName]))
            return $_COOKIE[$userName];
        else
            return null;
    }

    public static function logout()
    {
        global $lpCfg;
        $cookieName = $lpCfg["lpClassicAuth"]["CookieName"];

        setcookie($cookieName["user"], null, time()-1, "/");
        setcookie($cookieName["passwd"], null, time()-1, "/");
    }
}

