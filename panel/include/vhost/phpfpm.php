<?php

global $rpVHostType;

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