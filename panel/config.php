<?php

//$lpCfgMySQLDebug=true;

$rpDomain="rp2.jybox.net";
$rpAdminEmail="m@jybox.net";

$rpAdminUsers=array("rpadmin");
$rpNotAllowReg=array("root","default","admin","sudo");

$rpBuyStdUrl="http://item.taobao.com/item.htm?id=16169509767";
$rpBuyExtUrl="http://item.taobao.com/item.htm?id=21047624871";

$rpNewsUrl="https://raw.github.com/gist/4078878/borad.html";

$lpUrl="/LightPHP/";
$lpCfgCallback="cbLogin";

$lpCfgMySQL=array(
                   "host" => "localhost",
                   "dbname" => "rpadmin",
                   "user" => "rpadmin",
                   "pwd" => "passwd",
                   "charset" => "utf8"
                 );
                 
$rpROOT=dirname(__FILE__);

$rpNewVirtualHost=array(
                          "id" => "XXOO",
                          "domains" => substr(md5(time()),0,8) . ".{$rpDomain}",
                          "template" => "web",
                          "type" => "only",
                          "php" => "php",
                          "cgi" => "",
                          "static" => "css js jpg gif png ico zip rar exe",
                          "indexs" => "index.php index.html index.htm",
                          "autoindex" => 1,
                          "is404" => 1,
                          "root" => "/home/" . lpAuth::getUName() . "/web/",
                          "alias" => "{}",
                          "nginxaccess" => "/home/" . lpAuth::getUName() . "/nginx.access.log",
                          "nginxerror" => "/home/" . lpAuth::getUName() . "/nginx.error.log",
                          "apacheaccess" => "/home/" . lpAuth::getUName() . "/apache.access.log",
                          "apacheerror" => "/home/" . lpAuth::getUName() . "/apache.error.log",
                          "isssl" => 0,
                          "sslcrt" => "",
                          "sslkey" => ""
                       );
                 
?>
