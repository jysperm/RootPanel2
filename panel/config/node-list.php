<?php

global $rpL;

lpLocale::i()->load(["node-list"]);

// 描述, 名称, 物理内存(MiB), 内存(MiB), CPU(%), 硬盘(MiB), 流量(GiB/月)
$rpCfg["NodeList"] = [
    "rp1" => [
        "domain" => "rp.jybox.net",
        "name" => "Linode东京",
        "description" => $rpL["Node.rp1"],
        "PhyMemory" => 20,
        "memory" => 40,
        "cpu" => 0.02,
        "disk" => 500,
        "traffic" => 100,
    ],
    "rp2" => [
        "domain" => "rp2.jybox.net",
        "name" => "LocVPS美国西海岸(默认)",
        "description" => $rpL["Node.rp2"],
        "PhyMemory" => 25,
        "memory" => 50,
        "cpu" => 0.02,
        "disk" => 700,
        "traffic" => 50
    ],
    "rp3" => [
        "domain" => "rp3.jybox.net",
        "name" => "测试节点",
        "description" => $rpL["Node.rp3"],
        "PhyMemory" => 20,
        "memory" => 40,
        "cpu" => 0.02,
        "disk" => 500,
        "traffic" => 30
    ]
];