<?php

class rpApache2Type extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "Apache",
            "description" => "完全使用Apache2, 可使用Apache2的更多高级功能"
        ];
    }

    public function settingsHTML($old)
    {
        $sOnly = $old["settings"]["type"] == "only" ? "checked='checked'" : "";
        $sUnless = $old["settings"]["type"] == "unless" ? "checked='checked'" : "";
        return <<< HTML

<div class="control-group">
  <label class="control-label" for="indexs">&raquo;</label>
  <div class="controls">
    <label class="radio">
      <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="only" {$sOnly} />
      只将特定的后缀交给Apache处理
    </label>
    <label class="radio">
      <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="unless" {$sUnless} />
      不将特定的后缀交给Apache处理
    </label>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="indexs">特定后缀</label>
  <div class="controls">
    <input type="text" class="input-xxlarge" id="vhost-apache2-extension" name="vhost-apache2-extension" value="{$old["settings"]["extension"]}"/>
  </div>
</div>


HTML;
    }

    public function defaultSettings()
    {
        return ["type" => "unless", "extension" => "css js jpg gif png ico zip rar exe"];
    }

    public function checkSettings($settings, $source)
    {
        if(!in_array($settings["type"], ["unless", "only"]))
            return ["ok" => false, "msg" => "类型不正确"];

        if(!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => "数据源格式不正确"];

        if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/', $settings["extension"]) ||
            strlen($settings["extension"]) >256 )
            return ["ok" => false, "msg" => "扩展名不正确"];

        $settings["extension"] = trim(str_replace("  ", " ", $settings["extension"]));
        return ["ok" => true, "data" => ["type" => $settings["type"], "extension" => $settings["extension"]]];
    }

    public function createConfig($hosts)
    {
        global $rpROOT;
        $uname = $hosts["uname"];

        $tmpApache = new lpTemplate("{$rpROOT}/../cli/template/apache2-type.php");
        $tmpApache->setValues([
            "hosts" => $hosts,
            "uname" => $uname
        ]);

        $tmpNginx = new lpTemplate("{$rpROOT}/../cli/template/apache2-type.php");
        $tmpNginx->setValues([
            "hosts" => $hosts,
            "uname" => $uname
        ]);
        return [
            "apache" => $tmpApache->getOutput(),
            "nginx" => $tmpNginx->getOutput()
        ];
    }
}