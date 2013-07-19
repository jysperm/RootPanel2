<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpUWSGIType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "uWSGI(Python)",
            "description" => "uWSGI(Python)"
        ];
    }

    public function settingsHTML($old)
    {
        return <<< HTML

<div class="control-group">
  <label class="control-label" for="vhost-uwsgi-socket"><a href="#" rel="tooltip" title="uWSGI Socket，如：/home/my/uwsgi.sock">Socket</a></label>
  <div class="controls">
    <input type="text" class="input-xxlarge" id="vhost-uwsgi-socket" name="vhost-uwsgi-socket" value="{$old["settings"]["socket"]}"/>
  </div>
</div>

HTML;
    }

    public function defaultSettings()
    {
        return ["socket" => ""];
    }

    public function checkSettings($settings, $source)
    {
        if(!lpFactory::get("rpUserModel")->checkFileName($settings["socket"]))
            return ["ok" => false, "msg" => "请填写有效的socket地址"];

        if(!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        return ["ok" => true, "data" => ["socket" => $settings["socket"]]];
    }

    public function createConfig($hosts)
    {
        $tmp = new lpTemplate(rpROOT . "/../cli/template/uwsgi-type.php");
        $tmp["hosts"] = $hosts;
        return [
            "nginx" => $tmp->getOutput()
        ];
    }
}