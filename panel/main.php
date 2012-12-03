<?php

require_once("LightPHP/lp-load.php");
require_once("config.php");

require_once("{$rpROOT}/handler/global.php");

lpRoute::bindDir('/LightPHP/static/',"{$rpROOT}/LightPHP/static/");
lpRoute::bindHTMLFile('^/global.css(/|(/\?.*))?$',"{$rpROOT}/global.css");

lpRoute::bindTemplateFile('^/$',"{$rpROOT}/index.php");

lpRoute::bindPageFromFile('^/login(/|(/\?.*))?$',"{$rpROOT}/handler/user.php","Login");
lpRoute::bindPageFromFile('^/logout(/|(/\?.*))?$',"{$rpROOT}/handler/user.php","Logout");
lpRoute::bindPageFromFile('^/signup(/|(/\?.*))?$',"{$rpROOT}/handler/user.php","Signup");

lpRoute::bindPageFromFile('^/admin(/|(/\?.*))?$',"{$rpROOT}/handler/admin.php","AdminPage");
lpRoute::bindPageFromFile('^/panel(/|(/\?.*))?$',"{$rpROOT}/handler/panel.php","Panel");

lpRoute::bindTemplateFile('^/pay(/|(/\?.*))?$',"{$rpROOT}/template/pay.php");
lpRoute::bindTemplateFile('^/request-free(/|(/\?.*))?$',"{$rpROOT}/template/request-free.php");
lpRoute::bindTemplateFile('^/manual(/|(/\?.*))?$',"{$rpROOT}/template/manual.php");

lpRoute::bindActionFromFile('^/commit/panel(/|(/\?.*))?$',"{$rpROOT}/handler/panel.php","VirtualHost","do");
lpRoute::bindActionFromFile('^/commit/request(/|(/\?.*))?$',"{$rpROOT}/handler/panel.php","RequestAction","do");
lpRoute::bindActionFromFile('^/commit/loginas(/|(/\?.*))?$',"{$rpROOT}/handler/admin.php","LoginAsAction","do",false);
lpRoute::bindActionFromFile('^/commit/admin(/|(/\?.*))?$',"{$rpROOT}/handler/admin.php","AdminAction","do");

lpRoute::bindText(NULL,"404 - 不存在对应的处理器");

?>
