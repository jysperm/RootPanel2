<?php

class rpPHPFPMType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "PHP-FPM",
            "description" => "PHP-FPM(常规PHP网站, 默认), 也适用于其他fastcgi"
        ];
    }

    public function settingsHTML($old)
    {
        return <<< HTML

PHP-FPM守护进程(留空表示使用系统的)：
<input type="text" class="input-xxlarge" id="vhost-phpfpm-server" name="vhost-phpfpm-server" value="{$old["settings"]["server"]}"/>

HTML;
    }

    public function defaultSettings()
    {
        return ["server" => ""];
    }

    public function checkSettings($settings, $source)
    {
        if($settings["server"] && !rpUserModel::me()->checkFileName($settings["server"]))
            return ["ok" => false, "msg" => "请填写有效的socket地址或留空"];

        if(!rpUserModel::me()->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        return ["ok" => true, "data" => ["server" => $settings["server"]]];
    }
}