<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["node-list.jp1"] = <<< HTML

總所周知Linode是業界良心，質量和穩定性都有保證，且日本線路到大陸比較近.<br />
但該區域受到工信部重點關照，時常訪問不暢.

HTML;

$rpL["node-list.us1"] = <<< HTML

這個節點資源較多，無論是硬盤、內存、流量都較大.<br />
到大陸的速度也可以接受，而且該區域目前還未受到特殊關照.

HTML;

$rpL["node-list.hk1"] = <<< HTML

即將增加香港節點.<br />
該節點不提供PPTP.

HTML;

$rpL["node-list"] = [
    "jp1" => [
        "name" => "Linode東京(默認)",
        "description" => $rpL["node-list.jp1"],
    ],
    "us1" => [
        "name" => "LocVPS洛杉矶",
        "description" => $rpL["node-list.us1"],
    ],
    "hk1" => [
        "name" => "LocVPS香港(測試中)",
        "description" => $rpL["node-list.hk1"],
    ]
];

$rpL["node-list.location"] = "機房";
$rpL["node-list.minGuarantee"] = "最小保證";
$rpL["node-list.min"] = "最小";
$rpL["node-list.MemoryGuarantee"] = "內存保證";
$rpL["node-list.minCPUGuarantee"] = "最小CPU保證";
$rpL["node-list.disk"] = "磁盤空間";
$rpL["node-list.trafficPerMonth"] = "流量/月";
$rpL["node-list.domain"] = "域名";

$rpL["node-list.popover.minRes"] = <<< HTML

最小保證即任何情況下都可以保證這麽多的資源，如果服務器還剩余資源，則所有需要資源的賬戶均分剩余資源.<br />
例如服務器剩余100M內存，有兩個用戶需要更多內存，則每人分得50M額外內存.

HTML;

return $rpL;
