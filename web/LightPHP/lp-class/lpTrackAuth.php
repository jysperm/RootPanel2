<?php

/**
 *   该文件包含 lpTrachAuth 的类定义.
 *   @package LightPHP
 */

session_start();

/**
 *   跟踪验证.
 *
 *   该类提供更为高级的验证功能, 该类将会跟踪记录每一次会话, 你可以单独控制这些会话.
 */
class lpTrackAuth
{
    const USER = "lp_tauth_user";
    const PASSWD = "lp_tauth_token";

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

    static public function auth($user, $passwd)
    {
        if(array_key_exists("raw", $passwd))
            $passwd = ["db" => self::dbHash($user, $passwd["raw"])];

        if(array_key_exists("db", $passwd)) {
            if(static::getPasswd($user) == $passwd["db"])
                return true;
            else
                return false;
        }

        if(array_key_exists("token", $passwd)) {
            if(lpTrackAuthModel::find(["user" => $user, "token" => $passwd["token"]]))
                return true;
        }

        return false;
    }

    static public function creatToken($user)
    {
        $token = self::hash($user . mt_rand());

        lpTrackAuthModel::insert(["user" => $user, "token" => $token, "lastactivitytime" => time()]);

        return $token;
    }

    static public function login($user = null, $passwd = null)
    {
        if(isset($_SESSION["lpIsAuth"]) && $_SESSION["lpIsAuth"])
            return true;

        if(!$user || !$passwd) {
            if(!$user && isset($_COOKIE[static::USER]))
                $user = $_COOKIE[static::USER];

            if(!$passwd && isset($_COOKIE[static::PASSWD]))
                $passwd = $_COOKIE[static::PASSWD];

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

            $expire = time() + lpFactory::get("lpConfig.lpCfg")->get("CookieLimit");

            setcookie(static::USER, $user, $expire, "/");
            setcookie(static::PASSWD, $passwd["token"], $expire, "/");

            $_SESSION["lpIsAuth"] = true;

            static::succeedCallback($user);

            return true;
        }
        else
        {
            setcookie(static::PASSWD, null, time() - 1, "/");
            $_SESSION["lpIsAuth"] = false;
            return false;
        }
    }

    static public function uname()
    {
        if(isset($_COOKIE[static::USER]))
            return $_COOKIE[static::USER];
        else
            return null;
    }

    static public function logout()
    {
        $token = isset($_COOKIE[static::PASSWD]) ? $_COOKIE[static::PASSWD] : null;
        if(lpTrackAuthModel::find(["user" => self::uname(), "token" => $token]))
            lpTrackAuthModel::delete(["token" => $_COOKIE[static::PASSWD]]);

        setcookie(static::USER, null, time() - 1, "/");
        setcookie(static::PASSWD, null, time() - 1, "/");

        $_SESSION["lpIsAuth"] = false;
    }
}