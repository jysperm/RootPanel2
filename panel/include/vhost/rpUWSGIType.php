<?php

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

uWSGI Socket：
<input type="text" class="input-xxlarge" id="vhost-uwsgi-socket" name="vhost-uwsgi-socket" value="{$old["settings"]["socket"]}"/>

HTML;
    }

    public function defaultSettings()
    {
        return ["socket" => ""];
    }

    public function checkSettings($settings, $source)
    {
        if(!rpUserModel::me()->checkFileName($settings["socket"]))
            return ["ok" => false, "msg" => "请填写有效的socket地址"];

        if(!rpUserModel::me()->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        return ["ok" => true, "data" => ["socket" => $settings["socket"]]];
    }
}