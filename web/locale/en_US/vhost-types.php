<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["vhost.invalidSource"] = "The source is invalid";

$rpL["vhost.apache2.name"] = "Apache";
$rpL["vhost.apache2.description"] = "Use Apache2 completely to take advantages of more advanced Apache2 functions";
$rpL["vhost.apache2.only"] = "Pass specific extensions to Apache";
$rpL["vhost.apache2.unless"] = "DO NOT Pass specific extensions to Apache";
$rpL["vhost.apache2.extension"] = "Specific extentions";
$rpL["vhost.apache2.extension.tooltip"] = "extentions without the dot seperated by white spaces";
$rpL["vhost.apache2.invalidType"] = "The type is invalid";
$rpL["vhost.apache2.invalidExtension"] = "The extention is invalid";

$rpL["vhost.nginx.name"] = "Nginx Completely Static";
$rpL["vhost.nginx.description"] = "Nginx Completely Static does not support any script";

$rpL["vhost.phpfpm.name"] = "PHP-FPM";
$rpL["vhost.phpfpm.description"] = "PHP-FPM(Standard PHP website, default), also compatible with other FastCGI things";
$rpL["vhost.phpfpm.phpfpm"] = "PHP-FPM";
$rpL["vhost.phpfpm.phpfpm.tooltip"] = "An Unix Socket Address. Leave it blank to use the system default one.";
$rpL["vhost.phpfpm.invalidPhpfpm"] = "Please leave it blank or provide a valid socket address";

$rpL["vhost.proxy.name"] = "Reverse Proxy";
$rpL["vhost.proxy.description"] = "Reverse Proxy can be used on other websites or local ports.";
$rpL["vhost.proxy.host"] = "Change header";
$rpL["vhost.proxy.host.tooltip"] = "Leave it blank to ignore changes";
$rpL["vhost.proxy.invalidHost"] = "Please provide a valid domain";

$rpL["vhost.uwsgi.name"] = "uWSGI(Python)";
$rpL["vhost.uwsgi.description"] = "uWSGI(Python)";
$rpL["vhost.uwsgi.socket"] = "uWSGI Socket";
$rpL["vhost.uwsgi.socket.tooltip"] = "uWSGI Socket, e.g. : /home/my/uwsgi.sock";
$rpL["vhost.uwsgi.invalidSocket"] = "Please provide a valid socket address";

return $rpL;