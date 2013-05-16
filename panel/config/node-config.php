<?php

global $rpCfg;

$rpCfg["NodeName"] = "rp3测试节点";
$rpCfg["NodeID"] = "us2";

// 数据库连接信息
$rpCfg["MySQLDB"] = [
    "type" => "mysql",
    "host" => "localhost",
    "dbname" => "rpadmin",
    "user" => "rpadmin",
    "passwd" => "passwd",
    "charset" => "utf8"
];