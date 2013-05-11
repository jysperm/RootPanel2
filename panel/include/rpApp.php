<?php

class rpApp extends lpApp
{
    static private $locale;

    static public function helloWorld()
    {
        global $rpCfg, $rpROOT;

        self::initAutoload();

        require_once("{$rpROOT}/config/rp-config.php");

        self::$locale = new lpLocale("{$rpROOT}/locale");

        require_once("{$rpROOT}/config/main-config.php");
        require_once("{$rpROOT}/config/node-config.php");
        require_once("{$rpROOT}/config/node-list.php");
        require_once("{$rpROOT}/config/admin-list.php");

        $config = $rpCfg["MySQLDB"];
        self::registerDatabase(new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config["user"], $config["passwd"]));

        lpLocale::i()->load(["global"]);
    }

    static public function initAutoload()
    {
        global $rpROOT;

        spl_autoload_register(function ($name) use ($rpROOT) {
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

class rpDividePageMaker
{
    public function __invoke($page, $curPage)
    {
        if($curPage == $page || $page == lpDividePage::splitter)
            return "<li class='active'><a href='#'>{$page}</a></li>";
        else
            return "<li><a href='/ticket/list/{$page}/'>{$page}</a></li>";
    }
}