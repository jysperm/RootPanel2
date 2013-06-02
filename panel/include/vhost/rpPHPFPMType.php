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
        if($settings["server"] && !lpFactory::get("rpUserModel")->checkFileName($settings["server"]))
            return ["ok" => false, "msg" => "请填写有效的socket地址或留空"];

        if(!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        return ["ok" => true, "data" => ["server" => $settings["server"]]];
    }

    public function createConfig($settings, $source)
    {
        global $rpROOT;
        $uname = rpAuth::uname();
        $tmp = new lpTemplate("$rpROOT/../cli/template/php-fpm.php");
        $tmp["uname"] = $uname;

        file_put_contents("/tmp/temp", $tmp->getOutput());
        shell_exec("sudo cp /tmp/temp /etc/php5/fpm/pool.d/{$uname}");
        shell_exec("sudo chown root:root /etc/php5/fpm/pool.d/{$uname}");
        shell_exec("sudo chmod 700 /etc/php5/fpm/pool.d/{$uname}");

        $tmp = new lpTemplate("$rpROOT/../cli/template/php-fpm-type.php");
        $tmp->setValues([
            "settings" => $settings,
            "source" => $source,
            "uname" => $uname
        ]);
        return [
            "nginx" => $tmp->getOutput()
        ];
    }
}