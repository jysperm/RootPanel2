<?php

global $rpVHostType;

$rpVHostType["apache2"] = [
    "name" => "Apache",
    "description" => "完全使用Apache2, 可使用Apache2的更多高级功能",
    "html-setting" => function ($old) {
        $sOnly = $old["settings"]["type"] == "only" ? "checked='checked'" : "";
        $sUnless = $old["settings"]["type"] == "unless" ? "checked='checked'" : "";
        return <<< HTML

<label class="radio">
  <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="only" {$sOnly} />
  只将特定的后缀交给Apache处理
</label>
<label class="radio">
  <input type="radio" name="vhost-apache2-type" id="vhost-apache2-type" value="unless" {$sUnless} />
  不将特定的后缀交给Apache处理
</label>
特定后缀(不含点, 多个以空格隔开)：
<input type="text" class="input-xxlarge" id="vhost-apache2-extension" name="vhost-apache2-extension" value="{$old["settings"]["extension"]}"/>

HTML;
    },
    "default-settings" => function () {
        return ["type" => "unless", "extension" => "css js jpg gif png ico zip rar exe"];
    }
];