<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["base.titleSuffix"] = "RP主機，技術宅的虛擬主機";

$rpL["base.buy"] = "購買";
$rpL["base.sites"] = "站點展示";
$rpL["base.review"] = "客戶評價";
$rpL["base.manual"] = "用戶手冊";
$rpL["base.panel"] = "管理面板";
$rpL["base.pay-free"] = "申請試用";
$rpL["base.bbs"] = "公告和論壇";

$rpL["base.signup"] = "注冊";
$rpL["base.login"] = "登錄";
$rpL["base.logout"] = "注銷";

$rpL["base.tkTitle"] = <<< TEXT
開放工單：%s
待處理工單：%s
已處理工單：%s
TEXT;

$rpL["base.copyright"] = <<< TEXT
<script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
RootPanel %s %s %s
TEXT;
$rpL["base.copyright"] = sprintf($rpL["base.copyright"], c("Version")["main"], c("Version")["time"], c("Version")["type"]);

$rpL["base.fullTime"] = "Y.m.d H:i:s";

$rpL["base.userType"] = [
    "no" => "未購買",
    "free" => "免費試用版",
    "std" => "標准付費版",
    "ext" => "額外技術支持版"
];

return $rpL;