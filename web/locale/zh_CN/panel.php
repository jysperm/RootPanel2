<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["panel.title"] = "控制面板主页";

$rpL["panel.index"] = "概述";
$rpL["panel.access"] = "远程访问";
$rpL["panel.website"] = "Web站点管理";
$rpL["panel.log"] = "日志摘要";
$rpL["panel.fullLog"] = "详细日志";
$rpL["panel.ticket"] = "工单";

$rpL["panel.userType"] = "账户类型：";
$rpL["panel.expiredTime"] = "到期时间：";
$rpL["panel.renew"] = "续费";

$rpL["panel.change.ssh"] = "修改SSH/SFTP密码";
$rpL["panel.change.mysql"] = "修改MySQL密码";
$rpL["panel.change.panel"] = "修改面板(即该网页)密码";
$rpL["panel.change.pptp"] = "修改PPTP VPN密码";
$rpL["panel.change.extConfig"] = "修改配置文件";

$rpL["panel.website.ison"] = "是否开启";
$rpL["panel.website.id"] = "站点ID";
$rpL["panel.website.domain"] = "域名";
$rpL["panel.website.type"] = "站点类型";
$rpL["panel.website.source"] = "数据源";
$rpL["panel.addWebsite"] = "添加站点";

$rpL["panel.tooltip.ison"] = "表示网站是否被开启，只有开启了网站，才可以正常访问. 未开启则表示这仅仅是个网站设置的备份，未被启用";
$rpL["panel.tooltip.id"] = "每个站点有个唯一的ID, 在向客服求助时，可以很方便地指明所描述的站点";
$rpL["panel.tooltip.domain"] = "该站点所绑定的域名，更多参见请用户手册的`域名绑定与解析`";
$rpL["panel.tooltip.type"] = "该站点的类型模版，更多类型请点`修改`按钮";
$rpL["panel.tooltip.source"] = "该站点的数据来源，对于反向代理是目标站点，其他情况是站点根目录";
$rpL["panel.tooltip.extConfig"] = "如果该面板不能满足你奇葩的需求，那么你可以要求客服为你手写配置文件，额外的配置文件会显示在这里";

$rpL["panel.tooltip.dialog.domain"] = "该站点所绑定的域名，多个域名请以空格隔开，支持使用对子域名使用泛解析";
$rpL["panel.tooltip.alias"] = "将某个特殊前缀的URL，绑定到指定目录，前缀和目录用空格隔开，每行一对，如：\n/bbs /home/my/bbs/";
$rpL["panel.tooltip.index"] = "对于文件夹，默认显示的文件，以空格隔开";

$rpL["panel.logs.id"] = "ID";
$rpL["panel.logs.time"] = "时间";
$rpL["panel.logs.summary"] = "摘要";

$rpL["panel.extConfig"] = <<< HTML
<a href="#" rel="tooltip" title="{$rpL["panel.tooltip.extConfig"]}">额外</a>
的Nginx配置文件： 0字节(<a id="nginx-extConfig" href="#">查看</a>).<br />
额外的Apache2配置文件： 0字节(<a id="apache2-extConfig" href="#">查看</a>).
HTML;

$rpL["panel.logSummary"] = <<< HTML
<p>以下为最新15条的摘要 (<a href="/panel/logs/">详细日志</a>).</p>
HTML;

return $rpL;