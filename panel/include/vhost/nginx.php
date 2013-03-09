<?php

global $rpVHostType;

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