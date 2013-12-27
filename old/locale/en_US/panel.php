<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["panel.title"] = "Control Panel Home";

$rpL["panel.index"] = "Overview";
$rpL["panel.access"] = "Remote Access";
$rpL["panel.website"] = "Web Management";
$rpL["panel.log"] = "Logs";
$rpL["panel.fullLog"] = "Detailed Logs";
$rpL["panel.ticket"] = "Tickets";

$rpL["panel.userType"] = "Account Type:";
$rpL["panel.expiredTime"] = "Expire Date:";
$rpL["panel.renew"] = "Renewal";

$rpL["panel.change.ssh"] = "Change SSH/SFTP Password";
$rpL["panel.change.mysql"] = "Change MySQL Password";
$rpL["panel.change.panel"] = "Change Control Panel(Current System)Password";
$rpL["panel.change.pptp"] = "Change PPTP VPN Password";
$rpL["panel.change.extConfig"] = "Modify The Config File";

$rpL["panel.website.ison"] = "Active";
$rpL["panel.website.id"] = "Website ID";
$rpL["panel.website.domain"] = "Domains";
$rpL["panel.website.type"] = "Type";
$rpL["panel.website.source"] = "Source";
$rpL["panel.addWebsite"] = "Add website";

$rpL["panel.tooltip.ison"] = "Shows if the website is enabled. Your website can only be accessed when it is active. Inactive means this is only a backup of the website and is not enabled.";
$rpL["panel.tooltip.id"] = "Every website has its unique ID. You can provide it with our customer representative to identify you website easily.";
$rpL["panel.tooltip.domain"] = "The domains that binded to this website. For details, please refer to the user manual 'Bind a Domain'";
$rpL["panel.tooltip.type"] = "The type templates of this website. For more types, please click edit";
$rpL["panel.tooltip.source"] = "If the website is a reverse proxy website, this field is the source of this website. For other websites, this fields represents the root directory of the website.";
$rpL["panel.tooltip.extConfig"] = "If this control panel cannot fulfill your creative needs, you can ask our customer representatives to write a config manually for you and it will be displayed here.";

$rpL["panel.tooltip.dialog.domain"] = "You can bind several domains to this website, please use white space as the delimeter. It supports wild cards for subdomains.";
$rpL["panel.tooltip.alias"] = "To bind special prefix url to the directory by typing them together seperated by a white space in one line. This field contains one directive per line. e.g.\n/bbs /home/my/bbs/";
$rpL["panel.tooltip.index"] = "The default displayed file in a folder. Multiple file names are seperated by a white space.";

$rpL["panel.logs.id"] = "ID";
$rpL["panel.logs.time"] = "Time";
$rpL["panel.logs.summary"] = "Summary";

$rpL["panel.extConfig"] = <<< HTML
<a href="#" rel="tooltip" title="{$rpL["panel.tooltip.extConfig"]}">Extra</a>
 Nginx Configuration File: 0 Byte(<a id="nginx-extConfig" href="#">Details</a>).<br />
Extra Apache2 Configuration File: 0 Byte(<a id="apache2-extConfig" href="#">Details</a>).
HTML;

$rpL["panel.logSummary"] = <<< HTML
<p>15 latest messages (<a href="/panel/logs/">Detailed Logs</a>).</p>
HTML;

return $rpL;