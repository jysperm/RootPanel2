<?php

global $rpL;

$rpL["nodelist.location"] = "机房";
$rpL["nodelist.minGuarantee"] = "最小保证";
$rpL["nodelist.min"] = "最小";
$rpL["nodelist.MemoryGuarantee"] = "内存保证";
$rpL["nodelist.minCPUGuarantee"] = "最小CPU保证";
$rpL["nodelist.disk"] = "磁盘空间";
$rpL["nodelist.trafficPerMonth"] = "流量/月";
$rpL["nodelist.domain"] = "域名";

$rpL["nodelist.popover.minRes"] = <<< HTML

最小保证即任何情况下都可以保证这么多的资源，如果服务器还剩余资源，则所有需要资源的账户均分剩余资源.<br />
例如服务器剩余100M内存，有两个用户需要更多内存，则每人分得50M额外内存.

HTML;

$rpL["nodelist.rp1"] = <<< HTML

总所周知Linode是业界良心，质量和稳定性都有保证，且日本线路到大陆比较近.<br />
但该区域受到工信部重点关照，时常访问不畅.

HTML;

$rpL["nodelist.rp2"] = <<< HTML

这个节点资源较多，无论是硬盘、内存、流量都较大.<br />
到大陆的速度也可以接受，而且该区域目前还未受到特殊关照.

HTML;

$rpL["nodelist.rp3"] = <<< HTML

目前该节点用于进行面板和相关自动化脚本的测试，不接受付费用户.

HTML;
