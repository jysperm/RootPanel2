<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpVirtualHostModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if (!self::$metaData) {
            self::$metaData = [
                "db" => f("lpDBDrive"),
                "table" => "virtualhost",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "domains" => ["type" => self::TEXT],
                "lastchange" => ["type" => self::UINT],
                "general" => ["type" => self::JSON],
                "source" => ["type" => self::TEXT],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "settings" => ["type" => self::JSON],
                "ison" => ["type" => self::INT]
            ];

            foreach (self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }
}