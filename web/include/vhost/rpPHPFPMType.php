<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpPHPFPMType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => l("vhost.phpfpm.name"),
            "description" => l("vhost.phpfpm.description")
        ];
    }

    public function settingsHTML($old)
    {

        $lPhpfpm = l("vhost.phpfpm.phpfpm");
        $lPhpfpmTooltip = l("vhost.phpfpm.phpfpm.tooltip");

        return <<< HTML

<div class="control-group">
  <label class="control-label" for="vhost-phpfpm-server"><a href="#" rel="tooltip" title="{$lPhpfpmTooltip}">{$lPhpfpm}</a></label>
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
            return ["ok" => false, "msg" => l("vhost.phpfpm.invalidPhpfpm")];

        if(!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => l("vhost.invalidSource")];

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