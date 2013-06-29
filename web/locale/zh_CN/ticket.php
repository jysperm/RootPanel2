<?php

global $rpL;

$rpL["ticket.types"] = [
    "pay" => "财务问题",
    "panel" => "面板使用",
    "miao" => "调戏客服",
    "web" => "Web环境",
    "linux" => "Linux环境",
    "runtime" => "语言支持"
];

$rpL["ticket.types.long"] = [
    "pay" => "购买/续费/支付",
    "panel" => "面板使用/Bug汇报",
    "miao" => "调戏客服",
    "web" => "Web环境(Nginx/Apache2)",
    "linux" => "Linux环境",
    "runtime" => "语言支持(PHP/Python等)"
];

$rpL["ticket.status.open"] = "开放中";
$rpL["ticket.status.hode"] = "等待处理";
$rpL["ticket.status.finish"] = "已处理";
$rpL["ticket.status.closed"] = "已关闭";

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


