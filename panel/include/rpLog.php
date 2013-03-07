<?php

class rpLog
{
    static public function log($user, $type, $detail, $by=null)
    {
        $row = [
            "uname" => $user,
            "time" => time(),
            "type" => $type,
            "detail" => $detail,
            "by" => $by ? $by : $user,
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "ip" => rpTools::getIP()
        ];

        rpApp::q("log")->insert($row);
    }
}
