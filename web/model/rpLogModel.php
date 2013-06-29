<?php

class rpLogModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => f("lpDBDrive"),
                "table" => "log",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "time" => ["type" => self::UINT],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "info" => ["type" => self::JSON],
                "detail" => ["type" => self::JSON],
                "by" => ["type" => self::VARCHAR, "length" => 256],
                "ip" => ["type" => self::TEXT],
                "ua" => ["type" => self::TEXT]
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }

    /**
     * @param string     $user       被记录日志的用户名
     * @param string     $type       日志的类型
     * @param array      $info       根据日志类型提供的附加信息
     * @param array      $detail     更多详细信息
     * @param string     $by         日志的触发者(默认同$user)
     */
    static public function log($user, $type, $info, $detail, $by = null)
    {
        $log = [
            "uname" => $user,
            "time" => time(),
            "type" => $type,
            "info" => $info,
            "detail" => $detail,
            "by" => $by ? : $user,
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "ip" => rpTools::getIP()
        ];

        self::insert($log);
    }
}