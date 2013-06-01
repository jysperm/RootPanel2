<?php

class rpNginxType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "Nginx纯静态",
            "description" => "Nginx纯静态, 不支持任何脚本"
        ];
    }

    public function settingsHTML($old)
    {
        return "";
    }

    public function defaultSettings()
    {
        return [];
    }

    public function checkSettings($settings, $source)
    {
        if(!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        return ["ok" => true, "data" => []];
    }

    public function createConfig($settings, $source)
    {

    }
}