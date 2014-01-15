<?php

namespace RootPanel\Core\Core;

use LightPHP\Cache\Adapter\MemCache;
use LightPHP\Core\Handler;
use LightPHP\Core\Router;
use LightPHP\Locale\Adapter\JSONLocale;
use LightPHP\Locale\Locale;
use LightPHP\Model\Wrapper\CachedModel;
use LightPHP\Tool\Auth;
use LightPHP\Tool\Config;
use PDO;
use RootPanel\Core\Handler\UserHandler;
use RootPanel\Core\Model\UserModel;

define("rpCORE", rpROOT . "/Core");

class Application extends \LightPHP\Core\Application
{
    /** @var MemCache */
    public static $cache;
    /** @var Config */
    public static $config;
    public static $database;
    /** @var Auth */
    public static $auth;
    /** @var JSONLocale */
    public static $locale;

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

        self::$auth = new Auth(new UserModel);

        self::$locale = new JSONLocale(
            rpCORE . "/locale",
            Locale::checkLanguage(rpCORE . "/locale", c("DefaultLanguage"))
        );
    }

    public static function registerRouters()
    {
        Router::bind("^/user/(signup|login|logout|settings)/", function($page) {
            UserHandler::invokeREST($page, Handler::method());
        });
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

        function l($name, $_ = null)
        {
            $param = func_get_args();
            array_shift($param);
            return Application::$locale->get($name, $param);
        }
    }
}
