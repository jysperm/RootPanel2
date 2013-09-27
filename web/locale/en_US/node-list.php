<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["node-list.jp1"] = <<< HTML

As known to all, Linode provides stable and high quality services to any users.
Thus, we provide guaranteed services to all of our users.

HTML;

$rpL["node-list.us1"] = <<< HTML

This node has few accounts currently which means it has sufficient disk space, memory and bandwidth.<br />

HTML;

$rpL["node-list.hk1"] = <<< HTML

Hong Kong Node Comming Soon.<br />
This node does not support PPTP.

HTML;

$rpL["node-list"] = [
    "jp1" => [
        "name" => "Linode Tokyo(Default)",
        "description" => $rpL["node-list.jp1"],
    ],
    "us1" => [
        "name" => "LocVPS Log Angeles",
        "description" => $rpL["node-list.us1"],
    ],
    "hk1" => [
        "name" => "LocVPS Hong Kong(Testing)",
        "description" => $rpL["node-list.hk1"],
    ]
];

$rpL["node-list.location"] = "Location";
$rpL["node-list.minGuarantee"] = "Minimum Guarantee";
$rpL["node-list.min"] = "Minimum";
$rpL["node-list.MemoryGuarantee"] = "Memory Guarantee";
$rpL["node-list.minCPUGuarantee"] = "Minimum CPU Guarantee";
$rpL["node-list.disk"] = "Disk Storage";
$rpL["node-list.trafficPerMonth"] = "Bandwidth per month";
$rpL["node-list.domain"] = "Domains";

$rpL["node-list.popover.minRes"] = <<< HTML
Minimum Guarantee means the minimum amount you can gain at anytime.
If the server has additional resources, all users that needed more resources will share the additional resources equally.<br />
e.g. If ther server has 100M memory more and there are two users who need more, both of them gain 50M memory more.

HTML;

return $rpL;
