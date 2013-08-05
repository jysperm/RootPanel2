#!/usr/bin/php
<?php

define("rpROOT", dirname(__FILE__) . "/../web");

require_once(rpROOT . "/LightPHP/lp-load.php");
require_once(rpROOT . "/include/rpApp.php");
rpApp::helloWorld();

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");

$uname = $argv[1];

$diskLimitMB = c("NodeList")[c("NodeID")]["disk"];

$diskLimitSoft = intval($diskLimitMB * 1024 * 0.85);
$diskLimitHard = intval($diskLimitMB * 1024 * 1.2);

shell_exec("sudo useradd {$uname} -m -s/bin/bash");
shell_exec("sudo usermod -G {$uname} -a www-data");
shell_exec("sudo setquota -u {$uname} {$diskLimitSoft} {$diskLimitHard} 0 0 -a");

$db = lpFactory::get("PDO");
$db->exec(sprintf("CREATE USER '%s'@'localhost' IDENTIFIED BY '%s';", $uname, md5(lpStartTime + rand(PHP_INT_MAX))));
$db->exec(sprintf("GRANT ALL PRIVILEGES ON  `%s\\_%%` . * TO  '%s'@'localhost';", $uname, $uname));

