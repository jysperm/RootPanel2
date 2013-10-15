<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class App extends lpApp
{
    public static function helloWorld(array $config = [])
    {
        parent::helloWorld($config);

        define("rpCORE", rpROOT . "/core");

        self::registerShortFunc();
        self::initAutoload();

        /** @var lpConfig $rpCfg */
        $rpCfg = f("lpConfig");
        $configFiles = ["main"];
        foreach($configFiles as $i)
            $rpCfg->loadFromPHPFile(rpCORE . "/config/{$i}.php");

        lpFactory::register("lpLocale", function() {
            $path = rpCORE . "/locale";
            return new lpJSONLocale($path, self::checkLanguage($path, c("DefaultLanguage")));
        });

        lpFactory::register("PDO.LightPHP", function() {
            $c = c("MySQLDB");
            return new PDO("mysql:host={$c['host']};dbname={$c['dbname']}", $c["user"], $c["passwd"]);
        });

        lpFactory::register("lpSmtpMailer", function() {
            $c = c("SMTP");
            return new lpSmtpMailer($c["host"], $c["address"], $c["user"], $c["passwd"]);
        });
    }

    public static function initAutoload()
    {
        spl_autoload_register(function ($name) {
            $map = [

            ];

            if(in_array($name, array_keys($map)))
                $name = $map[$name];

            $paths = [
                rpCORE . "/include/{$name}.php",
                rpCORE . "/handler/{$name}.php",
                rpCORE . "/model/{$name}.php"
            ];

            foreach($paths as $path)
                if(file_exists($path))
                    return require_once($path);
        });
    }
}
