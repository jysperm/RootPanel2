<?php

class rpUserModel extends lpPDOModel
{
    static protected $metaData = null;

    const NO = "no";
    const STD = "std";
    const EXT = "ext";
    const FREE = "free";

    static private $me=null;

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
                "lastlogintime" => ["type" => self::UINT, "default" => 0],
                "lastloginip" => ["type" => self::TEXT, self::NOTNULL => false],
                "lasloginua" => ["type" => self::TEXT, self::NOTNULL => false],
            ];

            foreach(self::$metaData["struct"] as &$v)
                if(!isset($v[self::NOTNULL]))
                    $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }

    static public function byUName($uname)
    {
        return self::by("uname", $uname);
    }

    static public function me()
    {
        if(!self::$me)
            self::$me = self::byUName(rpAuth::uname());
        return self::$me;
    }

    public function isAllowToPanel()
    {
        if($this->data["type"] != self::NO && !$this->isAdmin())
            return true;
        else
            return false;
    }

    public function isAdmin()
    {
        global $rpCfg;

        return array_key_exists($this->data["uname"], $rpCfg["Admins"]);
    }

    public function checkFileName($filename)
    {
        $user = $this->data["uname"];
        $userDir = "/home/{$user}/";

        if(preg_match('%^[/A-Za-z0-9_\-\.]+/?$%', $filename) &&
            substr($filename, 0, strlen($userDir)) == $userDir &&
            strlen($filename) < 512  &&
            substr($filename, -3) != "/.." &&
            strpos($filename, "/../") === false)
            return true;
        return false;
    }
}