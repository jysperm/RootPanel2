<?php

class rpApp extends lpApp
{
    static public function helloWorld()
    {
        self::initAutoload();

        lpApp::registerShortFunc();

        function d()
        {
            /** @var PDO $db */
            $db = f("lpDBDrive");
            return $db;
        }

        /** @var lpConfig $cfg */
        $cfg = f("lpConfig");
        $cfg->load(rpROOT . "/config/rp-config.php");

        lpFactory::register("lpLocale", function() {
            return new lpLocale(rpROOT . "/locale", lpLocale::judegeLanguage(rpROOT . "/locale", c("DefaultLanguage")));
        });

        require_once("{$rpROOT}/config/main-config.php");
        require_once("{$rpROOT}/config/node-config.php");
        require_once("{$rpROOT}/config/node-list.php");
        require_once("{$rpROOT}/config/admin-list.php");

        lpFactory::register("lpDBDrive", function($tag) {
            global $rpCfg;
            $config = $rpCfg["MySQLDB"];

            if(!$tag)
                return new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config["user"], $config["passwd"]);
        });

        lpFactory::register("lpSmtp", function($tag) {
            global $rpCfg;

            if(!$tag)
                return new lpSmtp($rpCfg["smtp"]["host"], $rpCfg["smtp"]["address"], $rpCfg["smtp"]["user"], $rpCfg["smtp"]["passwd"]);
        });

        lpFactory::register("rpUserModel", function($tag){
            if(!$tag)
                return rpUserModel::by("uname", rpAuth::uname());
            else
                return rpUserModel::by("uname", $tag);
        });

        lpLocale::i()->load(["global"]);
    }

    static public function initAutoload()
    {
        spl_autoload_register(function ($name) {
            global $rpROOT;

            $map = [

            ];

            if(in_array($name, array_keys($map)))
                $name = $map[$name];

            $paths = [
                "{$rpROOT}/include/{$name}.php",
                "{$rpROOT}/handler/{$name}.php",
                "{$rpROOT}/model/{$name}.php",
                "{$rpROOT}/include/vhost/{$name}.php"
            ];

            foreach($paths as $path) {
                if(file_exists($path)) {
                    require_once($path);
                    return;
                }
            }
        });
    }
}
