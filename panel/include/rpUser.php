<?php

class rpUser
{
    const NO = "no";
    const STD = "std";
    const EXT = "ext";
    const FREE = "free";

    static function isAllowToPanel($user)
    {
        global $lpApp, $rpCfg;

        $q = new lpDBQuery($lpApp->getDB());
        $r = $q("user")->where(["uname" => $user])->top();
        if($r["type"] != rpUser::NO && !array_key_exists($user, $rpCfg["Admins"]))
            return true;
        else
            return false;
    }
}
