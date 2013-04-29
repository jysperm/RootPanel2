<?php

class rpAuth extends lpTrackAuth
{
    static public function getPasswd($uname)
    {
        return rpUserModel::find(["uname" => $uname])["passwd"];
    }

    static public function succeedCallback()
    {
        $row["lastlogintime"] = time();
        $row["lastloginip"] = rpTools::getIP();
        $row["lastloginua"] = $_SERVER["HTTP_USER_AGENT"];

        rpUserModel::update(["uname" => rpAuth::uname()], $row);
    }
}
