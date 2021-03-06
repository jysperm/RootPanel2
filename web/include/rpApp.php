<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpApp extends lpApp
{
    private static $atexit = [];

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
            rpROOT . "/config/node-config.php",
            rpROOT . "/config/license.php"
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

    public static function registerAtexit($func)
    {
        self::$atexit[]= $func;
    }

    public static function finishRequest()
    {
        if(function_exists("fastcgi_finish_request"))
        {
            session_write_close();
            fastcgi_finish_request();
        }

        foreach(self::$atexit as $f)
            $f();
    }

    public static function reloadWebConfig($uname)
    {
        rpApp::finishRequest();
        shell_exec(rpROOT . "/../cli/web-conf-maker.php {$uname}");
    }
}
