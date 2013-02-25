<?php

class rpApp extends lpApp
{
    static public function helloWorld()
    {
        global $rpCfg;

        self::registerDatabase(new lpMySQLDBDrive($rpCfg["MySQLDB"]));

        spl_autoload_register(function($name)
        {
            global $rpROOT;

            $map = [
                "rppublic" => "rpPublic",
                "rppay" => "rpPay",
                "rppanel" => "rpPanel",
                "rppanelaction" => "rpPanelAction"
            ];

            $paths = [
                "{$rpROOT}/cli-tools/{$name}.php",
                "{$rpROOT}/handler/{$name}.php"
            ];

            if(in_array($name, array_keys($map)))
                $name = $map[$name];

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

    static public function q($table=null)
    {
        $q = new lpDBQuery(self::getDB());
        if($table)
            return $q($table);
        return $q;
    }

}