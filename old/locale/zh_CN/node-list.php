<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["node-list.jp1"] = <<< HTML
总所周知Linode是业界良心，质量和稳定性都有保证，且日本线路到大陆比较近.<br />
但该区域受到工信部重点关照，时常访问不畅.
HTML;

$rpL["node-list.us1"] = <<< HTML
这个节点资源较多，无论是硬盘、内存、流量都较大.<br />
到大陆的速度也可以接受，而且该区域目前还未受到特殊关照.
HTML;

$rpL["node-list.hk1"] = <<< HTML
该节点到全国的速度都还不错，但是CPU和流量资源较为紧张<br />
该节点不提供PPTP.
HTML;

$rpL["node-list"] = [
    "jp1" => [
        "name" => "Linode东京(默认)",
        "description" => $rpL["node-list.jp1"],
    ],
    "us1" => [
        "name" => "LocVPS洛杉矶(已满)",
        "description" => $rpL["node-list.us1"],
    ],
    "hk1" => [
        "name" => "LocVPS香港(测试中)",
        "description" => $rpL["node-list.hk1"],
    ]
];

$rpL["node-list.location"] = "机房";
$rpL["node-list.minGuarantee"] = "最小保证";
$rpL["node-list.min"] = "最小";
$rpL["node-list.MemoryGuarantee"] = "内存保证";
$rpL["node-list.disk"] = "磁盘空间";
$rpL["node-list.trafficPerMonth"] = "流量/月";
$rpL["node-list.domain"] = "域名";

$rpL["node-list.popover.minRes"] = <<< HTML

最小保证即任何情况下都可以保证这么多的资源，如果服务器还剩余资源，则所有需要资源的账户均分剩余资源.<br />
例如服务器剩余100M内存，有两个用户需要更多内存，则每人分得50M额外内存.

HTML;

return $rpL;
