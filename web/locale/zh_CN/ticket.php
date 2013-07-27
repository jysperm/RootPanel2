<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["ticket.title"] = "工单列表";
$rpL["ticket.ticketList"] = "工单列表 #%s";
$rpL["ticket.create"] = "创建工单";

$rpL["ticket.list.id"] = "ID";
$rpL["ticket.list.type"] = "类型";
$rpL["ticket.list.status"] = "状态";
$rpL["ticket.list.title"] = "标题";
$rpL["ticket.list.reply"] = "回复";

$rpL["ticket.nav.opeator"] = "操作";
$rpL["ticket.nav.returnList"] = "返回列表";
$rpL["ticket.nav.returnPanel"] = "返回面板";

$rpL["ticket.opeator.close"] = "关闭工单";
$rpL["ticket.opeator.finish"] = "标记完成";
$rpL["ticket.opeator.content"] = "回复内容";
$rpL["ticket.opeator.reply"] = "创建回复";
$rpL["ticket.opeator.closed"] = "工单已被关闭";

$rpL["ticket.replyBy"] = "%s 个回复 | %s 于 %s";

$rpL["ticket.create.content"] = "内容";
$rpL["ticket.create.create"] = "创建工单";

$rpL["ticket.types"] = [
    "pay" => "财务问题",
    "panel" => "面板使用",
    "miao" => "调戏客服",
    "web" => "Web环境",
    "linux" => "Linux环境",
    "runtime" => "语言支持"
];
$rpL["ticket.types.default"] = "miao";

$rpL["ticket.types.long"] = [
    "pay" => "购买/续费/支付",
    "panel" => "面板使用/Bug汇报",
    "miao" => "调戏客服",
    "web" => "Web环境(Nginx/Apache2)",
    "linux" => "Linux环境",
    "runtime" => "语言支持(PHP/Python等)"
];

$rpL["ticket.status.open"] = "开放中";
$rpL["ticket.status.hode"] = "客服已回复";
$rpL["ticket.status.finish"] = "客服已处理";
$rpL["ticket.status.closed"] = "已关闭";

$rpL["ticket.handler.invalidType"] = "工单类型错误";
$rpL["ticket.handler.invalidID"] = "无效工单ID";
$rpL["ticket.handler.invalidPermission"] = "你对该工单没有权限";
$rpL["ticket.handler.alreadyClosed"] = "该工单已经关闭";
$rpL["ticket.handler.closeOnlyByAdmin"] = "该工单只能被管理员关闭";
$rpL["ticket.handler.notAdmin"] = "只有管理员可以标记完成";

$rpL["ticket.createMail.title"] = "TK Create | %s | %s | %s";
$rpL["ticket.createMail.body"] = <<< HTML
%s<br /><a href='http://%s/ticket/view/%s/'># %s | %s</a>
HTML;


$rpL["ticket.template"]["freeRequest"]["title"] = "试用申请";
$rpL["ticket.template"]["freeRequest"]["type"] = "pay";
$rpL["ticket.template"]["freeRequest"]["content"] = <<< HTML
## 请先填写下列问卷(100-300字为宜)
* 年龄, 职业
* 从何处得知RP主机
* 是否会编程，如果会的话掌握哪些技术
* 你将会用RP主机干什么
* 为什么选择了试用而不是直接购买

HTML;

$rpL["ticket.template"]["configRequest"]["title"] = "配置文件审核申请";
$rpL["ticket.template"]["configRequest"]["type"] = "web";
$rpL["ticket.template"]["configRequest"]["content"] = <<< HTML
## 请填写:
* 配置文件内容
* 主要功能描述
* 保证不会干扰到其他用户和服务器运行

HTML;

$rpL["ticket.admin.title"] = "工单";
$rpL["ticket.admin.openTicket"] = "开放工单";
$rpL["ticket.admin.allTicket"] = "所有工单";

$rpL["ticket.admin.objUser"] = "目标用户";
$rpL["ticket.admin.closeOnlyByAdmin"] = "只允许管理员关闭";

return $rpL;


