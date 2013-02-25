<?php

global $rpVHostType;

$rpVHostType = [];

$rpVHostType["phpfpm"] = [
    "name" => "PHP-FPM",
    "description" => "PHP-FPM(常规PHP网站, 默认)",
    "html-setting" => function ($old) {
        return <<< HTML

PHP-FPM守护进程(留空表示使用系统的)：
<input type="text" class="input-xxlarge" id="vhost-phpfpm-server" name="vhost-phpfpm-server" value="{$old["settings"]["server"]}"/>

HTML;
    },
    "default-settings" => function () {
        return ["server" => ""];
    }
];

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

$rpVHostType["proxy"] = [
    "name" => "反向代理",
    "description" => "反向代理, 可代理其他外网网站也可以代理本地的其他端口",
    "html-setting" => function ($old) {
        return <<< HTML

变更主机头为(留空表示不变更)：
<input type="text" class="input-xxlarge" id="vhost-proxy-host" name="vhost-proxy-host" value="{$old["settings"]["host"]}"/>

HTML;
    },
    "default-settings" => function () {
        return ["host" => ""];
    }
];

$rpVHostType["nginx"] = [
    "name" => "Nginx纯静态",
    "description" => "Nginx纯静态",
    "html-setting" => function ($old) {
        return <<< HTML

HTML;
    },
    "default-settings" => function () {
        return [];
    }
];

$rpVHostType["uwsgi"] = [
    "name" => "uWSGI(Python)",
    "description" => "uWSGI(Python)",
    "html-setting" => function ($old) {
        return <<< HTML

uWSGI Socket：
<input type="text" class="input-xxlarge" id="vhost-uwsgi-socket" name="vhost-uwsgi-socket" value="{$old["settings"]["socket"]}"/>

HTML;
    },
    "default-settings" => function () {
        return ["socket" => ""];
    }
];
