<?php

global $rpVHostType;

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