<?php

global $rpL;

$rpCfg["DefaultLanguage"] = "zh_CN";

// 管理员(客服)列表
$rpCfg["Admins"] = [
    "rpadmin" => [
        "name" => "精英王子",
        "description" => "会卖萌的技术宅，熟悉C++/Qt、PHP、Web前端、两年Linux使用和维护经验.",
        "email" => "m@jybox.net",
        "qq" => "184300584",
        "otherEmails" => ["jyboxnet@gmail.com"],
        "url" => "http://jyprince.me/"
    ]
];

// 禁止注册的用户名列表
$rpCfg["NotAllowSignup"] = ["root"];

$rpCfg["LogPerPage"] = 50;

$rpCfg["Pay"]["std"] = "http://item.taobao.com/item.htm?id=16169509767";
$rpCfg["Pay"]["ext"] = "http://item.taobao.com/item.htm?id=21047624871";

// Gravatar基准URL
//$rpCfg["GravaterURL"] = "http://www.gravatar.com/avatar/";
$rpCfg["GravaterURL"] = "http://ruby-china.org/avatar/";

// 多说站点ID
$rpCfg["duoshuoID"] = "rphost";

// 所有节点列表
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

// ----- 覆盖LightPHP的配置

$lpCfg["LightPHP"]["Mode"] = "debug";
