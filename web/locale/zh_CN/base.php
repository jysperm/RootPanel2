<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["base.titleSuffix"] = "RP主机，技术宅的虚拟主机";

$rpL["base.buy"] = "购买";
$rpL["base.sites"] = "站点展示";
$rpL["base.review"] = "客户评价";
$rpL["base.manual"] = "用户手册";
$rpL["base.panel"] = "管理面板";
$rpL["base.pay-free"] = "申请试用";
$rpL["base.bbs"] = "公告和论坛";

$rpL["base.signup"] = "注册";
$rpL["base.login"] = "登录";
$rpL["base.logout"] = "注销";

$rpL["base.tkTitle"] = <<< TEXT
开放工单：%s
待处理工单：%s
已处理工单：%s
TEXT;

$rpL["base.copyright"] = <<< TEXT
<script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
RootPanel %s %s %s
TEXT;
$rpL["base.copyright"] = sprintf($rpL["base.copyright"], c("Version")["main"], c("Version")["time"], c("Version")["type"]);

$rpL["base.data"] = "Y.m.d";
$rpL["base.fullTime"] = "Y.m.d H:i:s";

$rpL["base.userType"] = [
    "no" => "未购买",
    "free" => "免费试用版",
    "std" => "标准付费版",
    "ext" => "额外技术支持版"
];

return $rpL;