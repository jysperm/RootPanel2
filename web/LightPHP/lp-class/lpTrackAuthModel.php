<?php

class lpTrackAuthModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => lpFactory::get("lpDBDrive"),
                "table" => "lpTrackAuth",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "user" => ["type" => self::VARCHAR, "length" => 256],
                "token" => ["type" => self::TEXT],
                "lastActivityTime" => ["type" => self::UINT]
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }
}