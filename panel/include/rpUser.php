<?php

class rpUser
{
    const NO = "no";
    const STD = "std";
    const EXT = "ext";
    const FREE = "free";

    static function isAllowToPanel($user)
    {
        $r = rpApp::q("user")->where(["uname" => $user])->top();
        if($r["type"] != rpUser::NO && !self::isAdmin($user))
            return true;
        else
            return false;
    }

    static function isAdmin($user)
    {
        global $rpCfg;

        return array_key_exists($user, $rpCfg["Admins"]);
    }
}
