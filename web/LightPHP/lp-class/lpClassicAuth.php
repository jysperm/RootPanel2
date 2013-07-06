<?php

/**
*   该文件包含 lpClassicAuth 的类定义.
*
*   @package LightPHP
*/

class lpClassicAuth
{
    static public function succeedCallback($user)
    {

    }

    static public function getPasswd($uname)
    {

    }

    static public function hash($data)
    {
        return hash("sha256", $data);
    }

    static public function dbHash($user, $passwd)
    {
        return self::hash(self::hash($user) . self::hash($passwd));
    }

    static public function cookieHash($dbPasswd)
    {
        global $lpCfg;

        return self::hash(self::hash($lpCfg["lpClasssicAuth"]["SecurityCode"]) . $dbPasswd);
    }

    public static function auth($user, $passwd)
    {
        if(isset($passwd["raw"]))
            $passwd = ["db" => self::dbHash($user, $passwd["raw"])];

        if(isset($passwd["db"]))
        {
            if(self::getPasswd($user) == $passwd["db"])
                return true;
            else
                return false;
        }

        if(isset($paaswd["cookie"]))
        {
            if(self::cookieHash(self::getPasswd($user)) == $passwd["cookie"])
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

            if(!$passwd && isset($_COOKIE[$cookieName["passwd"]]))
                $passwd = $_COOKIE[$cookieName["passwd"]];

            if(!$user || !$passwd)
                return false;

            $passwd = ["cookie" => $passwd];
        }

        if(self::auth($user, $passwd))
        {
            if(isset($passwd["raw"]))
                $passwd = ["db" => self::dbHash($user, $passwd["raw"])];

            if(isset($passwd["db"]))
                $passwd = ["cookie" => self::cookieHash($user, $passwd["db"])];

            static::succeedCallback($user);

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

