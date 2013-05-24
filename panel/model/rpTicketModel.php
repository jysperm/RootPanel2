<?php

class rpTicketModel extends lpPDOModel
{
    static protected $metaData = null;

    const OPEN = "ticket.status.open";
    const HODE = "ticket.status.hode";
    const FINISH = "ticket.status.finish";
    const CLOSED = "ticket.status.closed";

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => lpFactory::get("PDO"),
                "table" => "ticket",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "time" => ["type" => self::UINT],
                "title" => ["type" => self::TEXT],
                "content" => ["type" => self::TEXT],
                "onlyclosebyadmin" => ["type" => self::INT],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "status" => ["type" => self::VARCHAR, "length" => 256],
                "lastchange" => ["type" => self::UINT],
                "replys" => ["type" => self::INT],
                "lastreply" => ["type" => self::VARCHAR, "length" => 256]
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }
}