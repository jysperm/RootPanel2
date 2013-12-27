<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["logs.title"] = "详细日志 #%s";

$rpL["logs.user"] = "(用户)";
$rpL["logs.actionBy"] = "操作者";
$rpL["logs.id"] = "ID";
$rpL["logs.ipua"] = "IP/UA";
$rpL["logs.time"] = "时间";
$rpL["logs.detail"] = "详情";

$rpL["logs.detailLog"] = "详细日志";
$rpL["logs.pageInfo"] = "#%s (共%s)";
$rpL["logs.returnPanel"] = "返回面板";

$rpL["logs.tooltip.logid"] = "每条日志有个唯一的ID, 可以很方便地向客服指明你所说的那条日志";
$rpL["logs.tooltip.by"] = "该条消息的触发者，可能是你自己，也可能是管理员";
$rpL["logs.tooltip.ipua"] = "操作者的IP, 悬停鼠标会显示UA";

return $rpL;