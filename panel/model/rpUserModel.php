<?php

class rpUserModel extends lpPDOModel
{
    static protected function init()
    {
        self::$db = rpApp::getDB();

        self::$struct = [
            "id" => ["type" => self::AI],
            "uname" => ["type" => self::VARCHAR, "length" => 256],
            "type" => ["type" => self::VARCHAR, "length" => 256],
            "passwd" => ["type" => self::TEXT],
            "email" => ["type" => self::TEXT],
            "qq" => ["type" => self::TEXT],
            "settings" => ["type" => self::TEXT],
            "regtime" => ["type" => self::UINT],
            "expired" => ["type" => self::UINT],
            "lastLoginTime" => ["type" => self::UINT],
            "lastLoginIP" => ["type" => self::TEXT],
            "lastLoginUA" => ["type" => self::TEXT],
        ];

        foreach(self::$struct as &$v)
            $v[self::NOTNULL] = true;

        self::$table = [
            "table" => "user",
            "engine" => "MyISAM",
            "charset" => "utf8",
            self::PRIMARY => "id"
        ];
    }
}