<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpApache2Type extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => l("vhost.apache2.name"),
            "description" => l("vhost.apache2.description")
        ];
    }

    public function settingsHTML($old)
    {
        $sOnly = $old["settings"]["type"] == "only" ? "checked='checked'" : "";
        $sUnless = $old["settings"]["type"] == "unless" ? "checked='checked'" : "";

        $lOnly = l("vhost.apache2.only");
        $lUnless = l("vhost.apache2.unless");
        $lExtension = l("vhost.apache2.extension");
        $lExtensionTooltip = l("vhost.apache2.extension.tooltip");

        return <<< HTML

<div class="control-group">
  <label class="control-label" for="vhost-apache2-type">&raquo;</label>
  <div class="controls">
    <label class="radio">
      <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="only" {$sOnly} />
      {$lOnly}
    </label>
    <label class="radio">
      <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="unless" {$sUnless} />
      {$lUnless}
    </label>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="vhost-apache2-extension"><a href="#" rel="tooltip" title="{$lExtensionTooltip}">{$lExtension}</a></label>
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
        if (!in_array($settings["type"], ["unless", "only"]))
            return ["ok" => false, "msg" => l("vhost.apache2.invalidType")];

        if (!lpFactory::get("rpUserModel")->checkFileName($source))
            return ["ok" => false, "msg" => l("vhost.invalidSource")];

        if (!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/', $settings["extension"]) ||
            strlen($settings["extension"]) > 256
        )
            return ["ok" => false, "msg" => l("vhost.apache2.invalidExtension")];

        $settings["extension"] = trim(str_replace("  ", " ", $settings["extension"]));
        return ["ok" => true, "data" => ["type" => $settings["type"], "extension" => $settings["extension"]]];
    }

    public function createConfig($hosts)
    {
        $uname = $hosts["uname"];

        $tmpApache = new lpTemplate(rpROOT . "/../cli/template/apache2.php");
        $tmpApache->setValues([
            "hosts" => $hosts,
            "uname" => $uname
        ]);

        $tmpNginx = new lpTemplate(rpROOT . "/../cli/template/apache2-type.php");
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