<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

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

<div class="control-group">
  <label class="control-label" for="vhost-phpfpm-server"><a href="#" rel="tooltip" title="一个Unix Socket地址，留空表示使用系统的">PHP-FPM</a></label>
  <div class="controls">
    <input type="text" class="input-xxlarge" id="vhost-phpfpm-server" name="vhost-phpfpm-server" value="{$old["settings"]["server"]}"/>
  </div>
</div>

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

    public function createConfig($hosts)
    {
        $uname = $hosts["uname"];

        if(rpVirtualHostModel::count(["uname" => $hosts["uname"], "type" => "phpfpm"]))
        {
            if(!file_exists("/etc/php5/fpm/pool.d/{$uname}.conf"))
            {
                $tmp = new lpTemplate(rpROOT . "/../cli/template/php-fpm.php");
                $tmp["uname"] = $uname;

                file_put_contents("/tmp/temp", $tmp->getOutput());
                shell_exec("sudo cp /tmp/temp /etc/php5/fpm/pool.d/{$uname}.conf");
                shell_exec("sudo kill -USR2 `cat /var/run/php5-fpm.pid`");
            }
        }
        else
        {
            if(file_exists("/etc/php5/fpm/pool.d/{$uname}.conf"))
            {
                shell_exec("sudo rm -f /etc/php5/fpm/pool.d/{$uname}.conf");
                if(shell_exec("sudo kill -USR2 `cat /var/run/php5-fpm.pid`")=="kill: No such process")
                {
                    shell_exec("service php5-fpm restart");
                }
            }
        }

        $tmp = new lpTemplate(rpROOT . "/../cli/template/php-fpm-type.php");
        $tmp->setValues([
            "hosts" => $hosts,
            "uname" => $uname
        ]);
        return [
            "nginx" => $tmp->getOutput()
        ];
    }
}