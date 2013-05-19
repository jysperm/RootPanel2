<?php

global $rpL, $rpCfg;;

lpLocale::i()->load(["node-list"]);

// 描述, 名称, 物理内存(MiB), 内存(MiB), CPU(%), 硬盘(MiB), 流量(GiB/月)
$rpCfg["NodeList"] = [
    "jp1" => [
        "domain" => "jp1.rpvhost.net",
        "name" => "Linode东京",
        "description" => $rpL["nodelist.rp1"],
        "memory" => 30,
        "cpu" => 480,
        "disk" => 350,
        "traffic" => 60,
    ],
    "us1" => [
        "domain" => "us1.rpvhost.net",
        "name" => "LocVPS洛杉矶(默认)",
        "description" => $rpL["nodelist.rp2"],
        "memory" => 48,
        "cpu" => 170,
        "disk" => 800,
        "traffic" => 48
    ],
    "us2" => [
        "domain" => "us2.rpvhost.net",
        "name" => "测试节点",
        "description" => $rpL["nodelist.rp3"],
        "memory" => 40,
        "cpu" => 200,
        "disk" => 500,
        "traffic" => 30
    ]
];