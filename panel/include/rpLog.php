<?php

class rpLog
{
    static public function log($user, $type, $info, $detail, $by=null)
    {
        $row = [
            "uname" => $user,
            "time" => time(),
            "type" => $type,
            "info" => json_encode($info),
            "detail" => $detail,
            "by" => $by ? $by : $user,
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "ip" => rpTools::getIP()
        ];

        rpApp::q("log")->insert($row);
    }
}
