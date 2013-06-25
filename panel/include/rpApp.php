<?php

class rpApp extends lpApp
{
    static public function helloWorld()
    {
        parent::helloWorld();

        self::registerShortFunc();
        self::initAutoload();

        function d()
        {
            /** @var PDO $db */
            $db = f("lpDBDrive");
            return $db;
        }

        lpFactory::register("lpConfig", function() {
            return new lpConfig;
        });

        /** @var lpConfig $rpCfg */
        $rpCfg = f("lpConfig");
        $rpCfg->load([
            rpROOT . "/config/rp-config.php",
            rpROOT . "/config/main-config.php",
            rpROOT . "/config/node-config.php"
        ]);

        lpFactory::register("lpLocale", function() {
            $path = rpROOT . "/locale";
            return new lpLocale($path, lpLocale::judegeLanguage($path, c("DefaultLanguage")));
        });

        lpFactory::register("lpDBDrive", function() {
            $c = c("MySQLDB");
            return new PDO("mysql:host={$c['host']};dbname={$c['dbname']}", $c["user"], $c["passwd"]);
        });

        lpFactory::register("lpSmtp", function() {
            $c = c("SMTP");
            return new lpSmtp($c["host"], $c["address"], $c["user"], $c["passwd"]);
        });

        lpFactory::register("rpUserModel", function($tag) {
            if(!$tag)
                return rpUserModel::by("uname", rpAuth::uname());
            else
                return rpUserModel::by("uname", $tag);
        });

        /** @var lpLocale $rpL */
        //$rpL = f("lpLocale");
        //$rpL->load("global");
    }

    static public function initAutoload()
    {
        spl_autoload_register(function ($name) {
            $map = [

            ];

            if(in_array($name, array_keys($map)))
                $name = $map[$name];

            $paths = [
                rpROOT . "/include/{$name}.php",
                rpROOT . "/handler/{$name}.php",
                rpROOT . "/model/{$name}.php",
                rpROOT . "/include/vhost/{$name}.php"
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
