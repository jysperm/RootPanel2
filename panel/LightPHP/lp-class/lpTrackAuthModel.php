<?php

class lpTrackAuthModel extends lpPDOModel
{
    static protected function init()
    {
        self::$db = lpApp::getDB();

        self::$struct = [
            "id" => ["type" => self::AI],
            "user" => ["type" => self::VARCHAR, "length" => 256],
            "token" => ["type" => self::TEXT],
            "lastActivityTime" => ["type" => self::UINT],
        ];

        foreach(self::$struct as &$v)
            $v[self::NOTNULL] = true;

        self::$table = [
            "table" => "lpTrackAuth",
            "engine" => "MyISAM",
            "charset" => "utf8",
            self::PRIMARY => "id"
        ];
    }
}