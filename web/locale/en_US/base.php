<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["base.titleSuffix"] = "RP Host For GEEKS!";

$rpL["base.buy"] = "Purchase";
$rpL["base.sites"] = "Sites Preview";
$rpL["base.review"] = "Comments";
$rpL["base.manual"] = "User Manual";
$rpL["base.panel"] = "Control Panel";
$rpL["base.pay-free"] = "Free Trail";
$rpL["base.bbs"] = "Announcements & Forum";

$rpL["base.signup"] = "Register";
$rpL["base.login"] = "Login";
$rpL["base.logout"] = "Logout";

$rpL["base.tkTitle"] = <<< TEXT
Open Tickets:%s
Pending Tickets:%s
Closed Tickets:%s
TEXT;

$rpL["base.copyright"] = <<< TEXT
<script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
RootPanel %s %s %s
TEXT;
$rpL["base.copyright"] = sprintf($rpL["base.copyright"], c("Version")["main"], c("Version")["time"], c("Version")["type"]);

$rpL["base.data"] = "Y.m.d";
$rpL["base.fullTime"] = "Y.m.d H:i:s";

$rpL["base.userType"] = [
    "no" => "Inactive",
    "free" => "Lite",
    "std" => "Standard",
    "ext" => "Pro"
];

return $rpL;