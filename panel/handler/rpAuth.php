<?php

class rpAuth extends lpTrackAuth
{
    static protected function succeedCallback()
    {
        $row["lastlogintime"] = time();
        $row["lastloginip"] = rpTools::getIP();
        $row["lastloginua"] = $_SERVER["HTTP_USER_AGENT"];

        $q = new lpDBQuery(rpApp::getDB());
        $q("user")->where(["uname" => rpAuth::uname()])->update($row);
    }
}
