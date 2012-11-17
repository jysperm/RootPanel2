<?php

require_once("LightPHP/lp-load.php");
require_once("config.php");

require_once("{$rpROOT}/handler/global.php");
require_once("{$rpROOT}/handler/user.php");
require_once("{$rpROOT}/handler/panel.php");
require_once("{$rpROOT}/handler/admin.php");


lpMVC::bindFile('^/$',"{$rpROOT}/index.php");

lpMVC::bingPage('^/login/?',new Login);
lpMVC::bingPage('^/logout/?',new Logout);
lpMVC::bingPage('^/signup/?',new Signup);

lpMVC::bingPage('^/admin/?',new AdminPage);
lpMVC::bindPage('^/panel/?',new Panel);

lpMVC::bindFile('^/pay/?',"{$rpROOT}/template/pay.php");
lpMVC::bindFile('^/news/?',"{$rpROOT}/template/news.php");
lpMVC::bindFile('^/request-free/?',"{$rpROOT}/template/request-free.php");
lpMVC::bindFile('^/manual/?',"{$rpROOT}/template/manual.php");

lpMVC::bindAction('^/commit/virtualhost/?',new VirtualHost,"do");
lpMVC::bindAction('^/commit/request/?',new Request,"do");
lpMVC::bindAction('^/commit/loginas/?',new LoginAs,"do");
lpMVC::bindAction('^/commit/admin/?',new AdminAction,"do");

echo '<meta charset="utf-8">404 - 不存在对应的处理器';

?>
