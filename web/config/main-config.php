<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

// 禁止注册的用户名列表
$rpCfg["NotAllowSignup"] = ["root"];

// 域名, 内存(MiB), CPU(MHz), 硬盘(MiB), 流量(GiB/月), 用户数
$rpCfg["NodeList"] = [
    "jp1" => [
        "domain" => "jp1.rpvhost.net",
        "memory" => 30,
        "cpu" => 480,
        "disk" => 350,
        "traffic" => 60,
        "users" => 40
    ],
    "us1" => [
        "domain" => "us1.rpvhost.net",
        "memory" => 48,
        "cpu" => 170,
        "disk" => 800,
        "traffic" => 48,
        "users" => 50
    ],
    "hk1" => [
        "domain" => "hk1.rpvhost.net",
        "memory" => 40,
        "cpu" => 110,
        "disk" => 1000,
        "traffic" => 12,
        "users" => 40
    ]
];

// 多说站点ID
$rpCfg["DuoshuoID"] = "rphost";

$rpCfg["AdminsEmail"] = "admins@rpvhost.net";

$rpCfg["SMTP"] = [
    "host" => "smtp.exmail.qq.com",
    "address" => "robot@rpvhost.net",
    "user" => "robot@rpvhost.net",
    "passwd" => "passswd"
];

return $rpCfg;
