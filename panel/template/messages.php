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



/* ----- panel.php ----- */

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

/* ----- sites.php ----- */

$msg["img300x200"] = "data:image/png;base64,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";