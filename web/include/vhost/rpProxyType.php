<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpProxyType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "反向代理",
            "description" => "反向代理, 可代理其他外网网站也可以代理本地的其他端口"
        ];
    }

    public function settingsHTML($old)
    {
        return <<< HTML

<div class="control-group">
  <label class="control-label" for="vhost-proxy-host"><a href="#" rel="tooltip" title="留空表示不变更">变更主机头</a></label>
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
            return ["ok" => false, "msg" => "请填写有效的域名"];

        if(!preg_match('%^http://[^\s]*$%', $source) ||
            strlen($source) > 512 )
            return ["ok" => false, "msg" => "数据源格式不正确"];

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