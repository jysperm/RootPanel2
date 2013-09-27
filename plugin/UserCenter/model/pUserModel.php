<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class pUserModel extends lpPDOModel
{
    protected static function metaData($data = null)
    {
        return parent::meta([
            "table" => "user",
            "struct" => [
                "id" => [self::INT, self::AI],
                "uname" => [self::VARCHAR => 256],
                "passwd" => [self::TEXT],
                "email" => [self::TEXT],
                "contacts" => [self::TEXT, self::JSON],
                "settings" => [self::TEXT, self::JSON],
                "signup_at" => [self::UINT],
                "group" => [self::TEXT, self::JSON]
            ]
        ]);
    }

    public function checkPasswd($passwd)
    {
        return $this->data["passwd"] == static::hashPasswd($this->data["uname"], $passwd);
    }

    // ----- static

    public static function byUName($uname)
    {
        return static::by("uname", $uname);
    }

    public static function existsWithUName($uname)
    {
        return static::count(["uname" => $uname]);
    }

    public static function register($uname, $passwd, $email, $contact)
    {
        return static::insert([
            "uname" => $uname,
            "passwd" => static::hashPasswd($uname, $passwd),
            "email" => $email,
            "contacts" => ["default" => $contact],
            "settings" => [],
            "signup" => time(),
            "group" => ["account" => "off"]
        ]);
    }

    public static function hashPasswd($uname, $passwd)
    {
        return hash("sha256", hash("sha256", $uname) . hash("sha256", $passwd));
    }
}