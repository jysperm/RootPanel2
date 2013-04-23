<?php

class rpLog
{
    /**
     * @param string     $user       被记录日志的用户名
     * @param string     $type       日志的类型
     * @param array      $info       根据日志类型提供的附加信息
     * @param array      $detail     更多详细信息
     * @param null       $by         日志的触发者(默认同$user)
     */
    static public function log($user, $type, $info, $detail, $by = null)
    {
        $row = [
            "uname" => $user,
            "time" => time(),
            "type" => $type,
            "info" => json_encode($info),
            "detail" => json_encode($detail),
            "by" => $by ? $by : $user,
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "ip" => rpTools::getIP()
        ];

        rpApp::q("Log")->insert($row);
    }
}
