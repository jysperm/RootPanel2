<?php

trait rpAppInit
{
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
                "{$rpROOT}/handler/{$name}.php"
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

trait rpAppDB
{

}

class rpApp extends lpApp
{
    use rpAppInit;

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

        self::registerDatabase(new lpPDODBDrive($rpCfg["MySQLDB"]));

        lpLocale::i()->load(["global"]);
    }

    static public function q($table = null)
    {
        $q = new lpDBQuery(self::getDB());
        if($table)
            return $q($table);
        return $q;
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