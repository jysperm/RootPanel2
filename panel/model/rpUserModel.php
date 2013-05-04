<?php

class rpUserModel extends lpPDOModel
{
    static protected $metaData = null;

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => rpApp::getDB(),
                "table" => "user",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "passwd" => ["type" => self::TEXT],
                "email" => ["type" => self::TEXT],
                "qq" => ["type" => self::TEXT],
                "settings" => ["type" => self::JSON],
                "regtime" => ["type" => self::UINT],
                "expired" => ["type" => self::UINT],
                "lastLoginTime" => ["type" => self::UINT],
                "lastLoginIP" => ["type" => self::TEXT],
                "lastLoginUA" => ["type" => self::TEXT],
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }

    static public function byUName($uname)
    {
        return new self(self::find(["uname" => $uname])["id"]);
    }

    static function isAllowToPanel($user)
    {
        $r = self::find(["uname" => $user]);
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