<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["panel.title"] = "控制面板主頁";

$rpL["panel.index"] = "概述";
$rpL["panel.access"] = "遠程訪問";
$rpL["panel.website"] = "Web站點管理";
$rpL["panel.log"] = "日志摘要";
$rpL["panel.fullLog"] = "詳細日志";
$rpL["panel.ticket"] = "工單";

$rpL["panel.userType"] = "賬戶類型：";
$rpL["panel.expiredTime"] = "到期時間：";
$rpL["panel.renew"] = "續費";

$rpL["panel.change.ssh"] = "修改SSH/SFTP密碼";
$rpL["panel.change.mysql"] = "修改MySQL密碼";
$rpL["panel.change.panel"] = "修改面板(即該網頁)密碼";
$rpL["panel.change.pptp"] = "修改PPTP VPN密碼";
$rpL["panel.change.extConfig"] = "修改配置文件";

$rpL["panel.website.ison"] = "是否開啓";
$rpL["panel.website.id"] = "站點ID";
$rpL["panel.website.domain"] = "域名";
$rpL["panel.website.type"] = "站點類型";
$rpL["panel.website.source"] = "數據源";
$rpL["panel.addWebsite"] = "添加站點";

$rpL["panel.tooltip.ison"] = "表示網站是否被開啓，只有開啓了網站，才可以正常訪問. 未開啓則表示這僅僅是個網站設置的備份，未被啓用";
$rpL["panel.tooltip.id"] = "每個站點有個唯壹的ID, 在向客服求助時，可以很方便地指明所描述的站點";
$rpL["panel.tooltip.domain"] = "該站點所綁定的域名，更多參見請用戶手冊的`域名綁定與解析`";
$rpL["panel.tooltip.type"] = "該站點的類型模版，更多類型請點`修改`按鈕";
$rpL["panel.tooltip.source"] = "該站點的數據來源，對于反向代理是目標站點，其他情況是站點根目錄";
$rpL["panel.tooltip.extConfig"] = "如果該面板不能滿足妳奇葩的需求，那麽妳可以要求客服爲妳手寫配置文件，額外的配置文件會顯示在這裏";

$rpL["panel.tooltip.dialog.domain"] = "該站點所綁定的域名，多個域名請以空格隔開，支持使用對子域名使用泛解析";
$rpL["panel.tooltip.alias"] = "將某個特殊前綴的URL，綁定到指定目錄，前綴和目錄用空格隔開，每行壹對，如：\n/bbs /home/my/bbs/";
$rpL["panel.tooltip.index"] = "對于文件夾，默認顯示的文件，以空格隔開";

$rpL["panel.logs.id"] = "ID";
$rpL["panel.logs.time"] = "時間";
$rpL["panel.logs.summary"] = "摘要";

$rpL["panel.extConfig"] = <<< HTML
<a href="#" rel="tooltip" title="{$rpL["panel.tooltip.extConfig"]}">額外</a>
的Nginx配置文件： 0字節(<a id="nginx-extConfig" href="#">查看</a>).<br />
額外的Apache2配置文件： 0字節(<a id="apache2-extConfig" href="#">查看</a>).
HTML;

$rpL["panel.logSummary"] = <<< HTML
<p>以下爲最新15條的摘要 (<a href="/panel/logs/">詳細日志</a>).</p>
HTML;

return $rpL;