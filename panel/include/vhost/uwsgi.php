<?php

global $rpVHostType;

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