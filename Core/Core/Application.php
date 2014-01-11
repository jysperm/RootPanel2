<?php

namespace RootPanel\Core\Core;

use LightPHP\Cache\Adapter\MemCache;
use LightPHP\Model\Wrapper\CachedModel;
use LightPHP\Tool\Config;
use PDO;

define("rpCORE", rpROOT . "/Core");

class Application extends \LightPHP\Core\Application
{
    /** @var MemCache */
    public static $cache;
    /** @var Config */
    public static $config;
    public static $database;

    public static function helloWorld(array $config = [])
    {
        parent::helloWorld($config);

        self::initAutoload();
        self::registerShortFunc();

        self::$config = new Config;
        self::$config->loadFromPHPFile(rpCORE . "/config/main.php");

        self::$cache = new MemCache(c("Cache.host"), c("Cache.ttl"), ["prefix" => c("Cache.prefix")]);
        CachedModel::$cache = self::$cache;

        $c = c("DB");
        self::$database = new PDO("mysql:host={$c['host']};dbname={$c['dbname']}", $c["user"], $c["passwd"]);
        Model::$source = self::$database;
    }

    public static function initAutoload()
    {
        spl_autoload_register(function ($name) {
            $paths = explode("\\", $name);
            $path = implode(DIRECTORY_SEPARATOR, $paths);
            $path = "{$path}.php";

            if(file_exists($path))
            {
                /** @noinspection PhpIncludeInspection */
                require_once($path);
            }
        });
    }

    public static function registerShortFunc()
    {
        function c($name)
        {
            $keys = explode(".", $name);
            $result = Application::$config->get(array_shift($keys));

            foreach($keys as $k)
            {
                if(!$result)
                    return $result;
                $result = $result[$k];
            }

            return $result;
        }
    }
}
