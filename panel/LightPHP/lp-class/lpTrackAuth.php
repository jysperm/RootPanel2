<?php

/**
*   该文件包含 lpTrachAuth 的类定义.
*
*   @package LightPHP
*/

/*
*   跟踪验证.
*
*   该类提供更为高级的验证功能, 该类将会跟踪记录每一次会话, 你可以单独控制这些会话.
*/

session_start();

class lpTrackAuth extends lpAuthDrive
{
    static public function hash($data)
    {
        return hash("sha256", $data);
    }

    static public function dbHash($user, $passwd)
    {
        return self::hash(self::hash($user) . self::hash($passwd));
    }

    static public function getPasswd($uname, $conn=null)
    {
        global $lpCfg;
        $cfg = $lpCfg["lpTrackAuth"]["GetPasswd"]["Default"];

        if(!$conn)
            $conn = lpApp::getDB();
        $q = new lpDBQuery($conn);

        return $q($cfg["table"])->where([$cfg["user"] => $uname])->top()[$cfg["passwd"]];
    }

    static public function auth($user, $passwd)
    {
        global $lpCfg;

        if(array_key_exists("raw", $passwd))
            $passwd = ["db" => self::dbHash($user, $passwd["raw"])];

        if(array_key_exists("db", $passwd))
        {
            if(self::getPasswd($user) == $passwd["db"])
                return true;
            else
                return false;
        }

        if(array_key_exists("token", $passwd))
        {
            $cfg = $lpCfg["lpTrackAuth"]["Default"];

            $q = new lpDBQuery(lpApp::getDB());

            $r = $q($cfg["table"])->where([$cfg["user"] => $user, $cfg["token"] => $passwd["token"]])->top();

            if($r)
                return true;
        }

        return false;
    }

    static public function creatToken($user)
    {
        global $lpCfg;
        $cfg = $lpCfg["lpTrackAuth"]["Default"];

        $token = self::hash($user . mt_rand());

        $q = new lpDBQuery(lpApp::getDB());

        $q($cfg["table"])->insert([$cfg["user"] => $user, $cfg["token"] => $token, $cfg["lastactivitytime"] => time()]);

        return $token;
    }

    static public function login($user=null, $passwd=null)
    {
        if(isset($_SESSION["lp_isauth"]) && $_SESSION["lp_isauth"])
            return true;

        global $lpCfg;
        $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];

        if(!$user || !$passwd)
        {
            if(!$user && isset($_COOKIE[$cookieName["user"]]))
                $user = $_COOKIE[$cookieName["user"]];

            if(!$passwd && isset($_COOKIE[$cookieName["passwd"]]))
                $passwd = $_COOKIE[$cookieName["passwd"]];

            if(!$user || !$passwd)
                return false;

            $passwd = ["token" => $passwd];
        }

        if(self::auth($user, $passwd))
        {
            if(isset($passwd["raw"]))
                $passwd = ["db" => self::hash($user, $passwd["raw"])];

            if(isset($passwd["db"]))
                $passwd = ["token" => self::creatToken($user)];

            self::succeedCallback();

            $expire = time() + $lpCfg["lpTrackAuth"]["Limit"];

            setcookie($cookieName["user"], $user, $expire, "/");
            setcookie($cookieName["passwd"], $passwd["token"], $expire, "/");

            $_SESSION["lp_isauth"] = true;

            return true;
        }
        else
        {
            setcookie($cookieName["passwd"], null, time()-1, "/");
            $_SESSION["lp_isauth"] = false;
            return false;
        }
    }

    static public function uname()
    {
        global $lpCfg;
        $userName = $lpCfg["lpTrackAuth"]["CookieName"]["user"];

        if(isset($_COOKIE[$userName]))
            return $_COOKIE[$userName];
        else
            return null;
    }

    static public function logout()
    {
        global $lpCfg;
        $cfg = $lpCfg["lpTrackAuth"]["Default"];
        $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];

        $q = new lpDBQuery(lpApp::getDB());
        $q($cfg["table"])->delete([$cfg["user"] => self::uname()]);

        setcookie($cookieName["user"], null, time()-1, "/");
        setcookie($cookieName["passwd"], null, time()-1, "/");

        $_SESSION["lp_isauth"] = false;
    }
}