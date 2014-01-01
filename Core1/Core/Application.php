<?php

namespace RootPanel\Core\Core;

class Application extends \LightPHP\Core\Application
{
    public static function helloWorld(array $config = [])
    {
        parent::helloWorld($config);

        define("rpCORE", rpROOT . "/Core");

        self::registerBuildInShortFunc();
        self::initAutoload();

        /** @var lpConfig $rpCfg */
        $rpCfg = f("lpConfig");
        $configFiles = ["main", "db", "library", "plugin"];
        foreach ($configFiles as $i)
            $rpCfg->loadFromPHPFile(rpCORE . "/config/{$i}.php");

        lpFactory::register("lpLocale", function () {
            $path = rpCORE . "/locale";
            return new lpJSONLocale($path, self::checkLanguage($path, c("DefaultLanguage")));
        });

        lpFactory::register("PDO.LightPHP", function () {
            $c = c("MySQLDB");
            return new PDO("mysql:host={$c['host']};dbname={$c['dbname']}", $c["user"], $c["passwd"]);
        });

        lpFactory::register("lpSmtpMailer", function () {
            $c = c("SMTP");
            return new lpSmtpMailer($c["host"], $c["address"], $c["user"], $c["passwd"]);
        });
    }

    public static function initAutoload()
    {
        spl_autoload_register(function ($name) {
            $map = [

            ];

            if (in_array($name, array_keys($map)))
                $name = $map[$name];

            $paths = [
                rpCORE . "/Core/{$name}.php",
                rpCORE . "/Handler/{$name}.php",
                rpCORE . "/Model/{$name}.php"
            ];

            foreach ($paths as $path)
                if (file_exists($path))
                    return require_once($path);
        });
    }
}
