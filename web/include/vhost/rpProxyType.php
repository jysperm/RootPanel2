<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpProxyType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => l("vhost.proxy.name"),
            "description" => l("vhost.proxy.description")
        ];
    }

    public function settingsHTML($old)
    {
        $lHost = l("vhost.proxy.host");
        $lHostTooltip = l("vhost.proxy.host.tooltip");

        return <<< HTML

<div class="control-group">
  <label class="control-label" for="vhost-proxy-host"><a href="#" rel="tooltip" title="{$lHostTooltip}">{$lHost}</a></label>
  <div class="controls">
    <input type="text" class="input-xxlarge" id="vhost-proxy-host" name="vhost-proxy-host" value="{$old["settings"]["host"]}"/>
  </div>
</div>

HTML;
    }

    public function defaultSettings()
    {
        return ["host" => ""];
    }

    public function checkSettings($settings, $source)
    {
        if($settings["host"] && !preg_match('/(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*/', $settings["host"]) ||
            strlen($settings["host"]) > 128 )
            return ["ok" => false, "msg" => l("vhost.proxy.invalidHost")];

        if(!preg_match('%^https?://[^\s]*$%', $source) ||
            strlen($source) > 512 )
            return ["ok" => false, "msg" => l("vhost.invalidSource")];

        return ["ok" => true, "data" => ["host" => $settings["host"]]];
    }

    public function createConfig($hosts)
    {
        $tmp = new lpTemplate(rpROOT . "/../cli/template/proxy-type.php");
        $tmp["hosts"] = $hosts;
        return [
            "nginx" => $tmp->getOutput()
        ];
    }
}