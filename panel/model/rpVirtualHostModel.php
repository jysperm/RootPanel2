<?php

class rpVirtualHostModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => rpApp::getDB(),
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
                "general" => ["type" => self::TEXT],
                "source" => ["type" => self::TEXT],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "settings" => ["type" => self::TEXT],
                "ison" => ["type" => self::INT]
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }
}