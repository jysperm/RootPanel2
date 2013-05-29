#!/usr/bin/php
<?php

global $rpCfg;

$rpROOT = dirname(__FILE__);
$rpROOT = "{$rpROOT}/../panel";

require_once("{$rpROOT}/LightPHP/lp-load.php");
require_once("{$rpROOT}/include/rpApp.php");
rpApp::helloWorld();

function createPasswd($length = 8)
{
    $passwd = '';
    for ($i = 0; $i < $length; $i++)
        $passwd .= chr(mt_rand(33, 126));
    return $passwd;
}

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");

$uname = $argv[1];

$diskLimitMB = $rpCfg["NodeList"][$rpCfg["NodeID"]]["disk"];

shell_exec("sudo useradd {$uname} -m -s/bin/bash");
shell_exec("sudo usermod -G {$uname} -a www-data");
shell_exec("sudo setquota -u {$uname} " . ($rpDiskLimitMB * 1000 * 0.85) . " " . ($rpDiskLimitMB * 1000 * 1.2) . " 0 0 -a");
shell_exec("echo 'source /etc/profile.d/rvm.sh' | sudo tee -a /home/{$uname}/.bashrc");

$db = lpFactory::get("PDO");
$db->exec(sprintf("CREATE USER '%s'@'localhost' IDENTIFIED BY '%s';", $uname, createPasswd(30)));
$db->exec(sprintf("GRANT ALL PRIVILEGES ON  `%s\_%%` . * TO  '%s'@'localhost';", $uname, $uname));

