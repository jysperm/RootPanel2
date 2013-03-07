<?php

trait rpAppInit
{
    static public function initAutoload()
    {
        global $rpROOT;

        spl_autoload_register(function($name) use($rpROOT)
        {
            $map = [
                "rppublic" => "rpPublic",
                "rppay" => "rpPay",
                "rppanel" => "rpPanel",
                "rppanelaction" => "rpPanelAction"
            ];

            if(in_array($name, array_keys($map)))
                $name = $map[$name];

            $paths = [
                "{$rpROOT}/include/{$name}.php",
                "{$rpROOT}/handler/{$name}.php"
            ];

            foreach($paths as $path)
            {
                if(file_exists($path))
                {
                    require_once($path);
                    return;
                }
            }
        });
    }

    static public function initTranslation()
    {
        global $rpROOT,$rpCfg;

        $lang = isset($_COOKIE["language"]) ? $_COOKIE["language"] : DefaultLanguage;
        if(!$lang  || !is_dir("{$rpROOT}/locale/{$lang}"))
            $lang = DefaultLanguage;

        $translations = [
            "user",
            "global",
            "messages",
            "node-list"
        ];

        foreach($translations as $file)
            require_once("{$rpROOT}/locale/{$lang}/{$file}.php");

        $rpCfg["lang"] = $lang;
    }
}

trait rpAppDB
{

}

class rpApp extends lpApp
{
    use rpAppInit;

    static public function helloWorld()
    {
        global $rpCfg, $rpROOT;

        self::initAutoload();
        self::initTranslation();

        require_once("{$rpROOT}/main-config.php");
        require_once("{$rpROOT}/node-config.php");

        require_once("{$rpROOT}/locale/{$rpCfg["lang"]}/contant.php");

        self::registerDatabase(new lpPDODBDrive($rpCfg["MySQLDB"]));
    }

    static public function q($table=null)
    {
        $q = new lpDBQuery(self::getDB());
        if($table)
            return $q($table);
        return $q;
    }

}