<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["admin-action.notLogin"] = "你还没有登录";
$rpL["admin-action.notAdmin"] = "你不是管理员";

$rpL["admin-action.ticket.alert.title"] = "你的账户将于 %s 到期";
$rpL["admin-action.ticket.alert.content"] = <<<HTML
你的账户将于 %s 到期。

请及时登录面板进行续费，否则你的数据将会被销毁，有任何疑问请咨询管理员。
HTML;

$rpL["admin-action.ticket.enable.title"] = "你的账户已被开通为 %s";
$rpL["admin-action.ticket.enable.content"] = <<<HTML
你的账户已被开通为 %s。

如果在使用中遇到问题，请联系客服。
HTML;

$rpL["admin-action.ticket.diasble.title"] = "你的账户数据已被销毁";
$rpL["admin-action.ticket.diasble.content"] = <<<HTML
你的账户数据已被销毁，大概是你没有按时续费，有任何疑问请咨询管理员。
HTML;


return $rpL;