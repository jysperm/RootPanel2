<?php

global $rpCfg, $msg;



/* ----- signup.php ----- */





/* ----- login.php ----- */

$adminEMail = array_values($rpCfg["Admins"])[0]["email"];

$msg["resetPasswdEMail"] = <<< HTML

请用你的注册邮箱，向客服邮箱<code><i class="icon-envelope"></i>{$adminEMail}</code>发送邮件.

HTML;

$msg["resetPasswdQQ"] = <<< HTML

使用你设置的QQ, 联系客服 {$msg["qqButtun"]}.

HTML;

/* ----- pay-free.php ----- */

$msg["requstSendOk"] = <<< HTML

<script type="text/javascript">
    alert("发送成功，请耐心等待回复，不要重复发送...");
    window.location.href = "/";
</script>

HTML;

/* ----- node-list.php ----- */

$msg["minRes"] = <<< HTML

最小保证即任何情况下都可以保证这么多的资源，如果服务器还剩余资源，则所有需要资源的账户均分剩余资源.<br />
例如服务器剩余100M内存，有两个用户需要更多内存，则每人分得50M额外内存.

HTML;



/* ----- index.php ----- */

$msg["isonHelp"] = "表示网站是否被开启，只有开启了网站，才可以正常访问. 未开启则表示这仅仅是个网站设置的备份，未被启用";
$msg["idHelp"] = "每个站点有个唯一的ID, 在向客服求助时，可以很方便地指明所描述的站点";
$msg["domainHelp"] = "该站点所绑定的域名，更多参见请用户手册的`域名绑定与解析`";
$msg["typeHelp"] = "该站点的类型模版，更多类型请点`修改`按钮";
$msg["sourceHelp"] = "该站点的数据来源，站点类型不同，来源的类型也不同";
$msg["extconfHelp"] = "如果该面板不能满足你奇葩的需求，那么你可以要求客服为你手写配置文件，额外的配置文件会显示在这里";

$msg["uiUserType"] = [
    "no" => "未购买",
    "free" => "免费试用版",
    "std" => "标准付费版",
    "ext" => "额外技术支持版"
];

/* ----- logs.php ----- */

$msg["logidHelp"] = "每条日志有个唯一的ID, 可以很方便地向客服指明你所说的那条日志";
$msg["byHelp"] = "该条消息的触发者，可能是你自己，也可能是管理员";
$msg["ipuaHelp"] = "操作者的IP, 悬停鼠标会显示UA";