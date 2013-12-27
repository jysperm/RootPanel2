<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["vhost.invalidSource"] = "数据源格式不正确";

$rpL["vhost.apache2.name"] = "Apache";
$rpL["vhost.apache2.description"] = "完全使用Apache2, 可使用Apache2的更多高级功能";
$rpL["vhost.apache2.only"] = "只将特定的后缀交给Apache处理";
$rpL["vhost.apache2.unless"] = "不将特定的后缀交给Apache处理";
$rpL["vhost.apache2.extension"] = "特定后缀";
$rpL["vhost.apache2.extension.tooltip"] = "后缀名，以空格隔开，不包含点";
$rpL["vhost.apache2.invalidType"] = "类型不正确";
$rpL["vhost.apache2.invalidExtension"] = "后缀名格式不正确";

$rpL["vhost.nginx.name"] = "Nginx纯静态";
$rpL["vhost.nginx.description"] = "Nginx纯静态, 不支持任何脚本";

$rpL["vhost.phpfpm.name"] = "PHP-FPM";
$rpL["vhost.phpfpm.description"] = "PHP-FPM(常规PHP网站, 默认), 也适用于其他FastCGI";
$rpL["vhost.phpfpm.phpfpm"] = "PHP-FPM";
$rpL["vhost.phpfpm.phpfpm.tooltip"] = "一个Unix Socket地址，留空表示使用系统的";
$rpL["vhost.phpfpm.invalidPhpfpm"] = "请填写有效的Socket地址或留空";

$rpL["vhost.proxy.name"] = "反向代理";
$rpL["vhost.proxy.description"] = "反向代理, 可代理其他外网网站也可以代理本地的其他端口";
$rpL["vhost.proxy.host"] = "变更主机头";
$rpL["vhost.proxy.host.tooltip"] = "留空表示不变更";
$rpL["vhost.proxy.invalidHost"] = "请填写有效的域名";

$rpL["vhost.uwsgi.name"] = "uWSGI(Python)";
$rpL["vhost.uwsgi.description"] = "uWSGI(Python)";
$rpL["vhost.uwsgi.socket"] = "uWSGI Socket";
$rpL["vhost.uwsgi.socket.tooltip"] = "uWSGI Socket，如：/home/my/uwsgi.sock";
$rpL["vhost.uwsgi.invalidSocket"] = "请填写有效的socket地址";

return $rpL;