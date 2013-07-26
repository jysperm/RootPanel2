<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpCfg["Version"] = [
    "main" => "2.2.0 B",
    "time" => "2013.7.26",
    "type" => "of",

    "Bootstrap" => "2.3.2",
    "jQuery" => "2.0.2"
];

$rpCfg["DefaultLanguage"] = "zh_CN";

// 每页显示日志条数
$rpCfg["LogPerPage"] = 30;
// 每页显示工单条数
$rpCfg["TKPerPage"] = 15;

return $rpCfg;
