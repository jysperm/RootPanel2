<?php

abstract class rpVHostType
{
    abstract public function meta();
    abstract public function settingsHTML($old);
    abstract public function defaultSettings();

    static public function loadTypes()
    {
        $types = [
            "PHPFPM", "Proxy", "Apache2", "Nginx", "UWSGI"
        ];

        $objs = [];
        foreach($types as $v)
        {
            $name = "rp{$v}Type";
            $objs[strtolower($v)]= new $name;
        }


        return $objs;
    }
}