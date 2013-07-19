<?php

$rpCfg["NodeName"] = "RootPanel 2.0";
$rpCfg["NodeID"] = "hk1";

// 静态文件前缀，通过该选项可以将静态文件置于另外的服务器
$rpCfg["StaticPrefix"] = "/static";

$rpCfg["BootstrapPrefix"] = "{$rpCfg["StaticPrefix"]}/bootstrap-" . c("Version")["Bootstrap"];
$rpCfg["jQueryPrefix"] = "{$rpCfg["StaticPrefix"]}/jquery-" . c("Version")["jQuery"];

// Gravatar基准URL
$rpCfg["GravaterURL"] = "http://www.gravatar.com/avatar/";
$rpCfg["GravaterURL"] = "http://ruby-china.org/avatar/";

$rpCfg["Admins"] = ["rpadmin"];

// 数据库连接信息
$rpCfg["MySQLDB"] = [
    "type" => "mysql",
    "host" => "localhost",
    "dbname" => "rpadmin",
    "user" => "rpadmin",
    "passwd" => "passwd",
    "charset" => "utf8"
];

return $rpCfg;