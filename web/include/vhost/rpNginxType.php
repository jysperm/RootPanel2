<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpNginxType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => l("vhost.nginx.name"),
            "description" => l("vhost.nginx.description")
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
            return ["ok" => false, "msg" => l("vhost.invalidSource")];

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