#!/usr/bin/php
<?php

define("rpROOT", dirname(__FILE__) . "/..");

require_once(rpROOT . "/build/config.php");
require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/Core/Core/Application.php");
Application::helloWorld();

$baseOutputDir = rpROOT . "/static/library";

$files = [
    "http://cdn.staticfile.org/" => [
        "twitter-bootstrap/" => [
            "3.0.3/" => [
                "css/" => [
                    "bootstrap-theme.css",
                    "bootstrap-theme.min.css",
                    "bootstrap.css",
                    "bootstrap.min.css"
                ],
                "font/" => [
                    "glyphicons-halflings-regular.eot",
                    "glyphicons-halflings-regular.svg",
                    "glyphicons-halflings-regular.ttf",
                    "glyphicons-halflings-regular.woff"
                ],
                "js/" => [
                    "bootstrap.js",
                    "bootstrap.min.js"
                ]
            ]
        ],

        "jquery/" => [
            "2.0.3/" => [
                "jquery.js",
                "jquery.min.js",
                "jquery.min.map"
            ]
        ]
    ]
];

$funcDownload = function ($url) use ($baseOutputDir) {
    $urlItem = explode("/", $url);
    $filename = end($urlItem);
    $data = file_get_contents($url);
    if (!file_put_contents("{$baseOutputDir}/{$filename}", $data))
        throw new lpException($php_errormsg, error_get_last());
};

$funcProcess = function ($dir, array $path = []) use (&$funcPrecess, $funcDownload) {
    if (is_array($dir)) {
        foreach ($dir as $k => $v) {
            $newPath = $path;
            $newPath[] = $k;
            $funcPrecess($v, $newPath);
        }
    } else {
        $path[] = $dir;
        $funcDownload(implode("", $path));
    }
};

$funcProcess($files);
