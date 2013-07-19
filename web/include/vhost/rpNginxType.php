<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

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

    public function createConfig($hosts)
    {
        $tmp = new lpTemplate(rpROOT . "/../cli/template/nginx-type.php");
        $tmp["hosts"] = $hosts;
        return [
            "nginx" => $tmp->getOutput()
        ];
    }
}