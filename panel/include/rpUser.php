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

        $r = rpApp::q("user")->where(["uname" => $user])->top();
        if($r["type"] != rpUser::NO && !array_key_exists($user, $rpCfg["Admins"]))
            return true;
        else
            return false;
    }
}
