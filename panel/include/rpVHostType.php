<?php

abstract class rpVHostType
{
    abstract public function meta();
    abstract public function settingsHTML($old);
    abstract public function defaultSettings();

    /**
     * @param $settings
     * @param $source
     *
     * @return array ["ok" => true|false, "msg" => <错误信息>, "data" => <成功过滤后的数据(数组)>]
     */
    abstract public function checkSettings($settings, $source);

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