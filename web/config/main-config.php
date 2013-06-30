<?php

// 禁止注册的用户名列表
$rpCfg["NotAllowSignup"] = ["root"];

// 域名, 内存(MiB), CPU(%), 硬盘(MiB), 流量(GiB/月)
$rpCfg["NodeList"] = [
    "jp1" => [
        "domain" => "jp1.rpvhost.net",
        "memory" => 30,
        "cpu" => 480,
        "disk" => 350,
        "traffic" => 60,
    ],
    "us1" => [
        "domain" => "us1.rpvhost.net",
        "memory" => 48,
        "cpu" => 170,
        "disk" => 800,
        "traffic" => 48
    ],
    "test" => [
        "domain" => "test.rpvhost.net",
        "memory" => 40,
        "cpu" => 200,
        "disk" => 500,
        "traffic" => 30
    ]
];

$rpCfg["Pay"] = [
    "std" => "http://item.taobao.com/item.htm?id=16169509767",
    "ext" => "http://item.taobao.com/item.htm?id=21047624871"
];

// 多说站点ID
$rpCfg["DuoshuoID"] = "rphost";

$rpCfg["AdminsEmail"] = "admins@rpvhost.net";

$rpCfg["SMTP"] = [
    "host" => "smtp.exmail.qq.com",
    "address" => "robot@rpvhost.net",
    "user" => "robot@rpvhost.net",
    "passwd" => "OrQGMW4a7oyJgb6f"
];

return $rpCfg;
