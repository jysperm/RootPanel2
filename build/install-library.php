#!/usr/bin/php
<?php

namespace RootPanel\CLI;

use LightPHP\Core\Exception;

include("./config.php");

$baseOutputDir = "{$baseOutputDir}/library";

$files = [
    "http://cdn.staticfile.org/" => [
        "twitter-bootstrap/" => [
            "{$config["bootstrap"]}/" => [
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
            "{$config["jquery"]}/" => [
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
        throw new Exception($php_errormsg, error_get_last());
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
