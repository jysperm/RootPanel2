<?php

$rpCfg["NodeName"] = "RootPanel 2.0";
$rpCfg["NodeID"] = "us2";

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