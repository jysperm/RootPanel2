<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpTicketReplyModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => f("lpDBDrive"),
                "table" => "ticketreply",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "time" => ["type" => self::UINT],
                "replyto" => ["type" => self::INT],
                "content" => ["type" => self::TEXT],
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }
}