#!/usr/bin/php
<?php

require_once("/RootPanel/LightPHP/lp-load.php");
require_once("/RootPanel/panel/main-config.php");

function create_password($pw_length = 8)
{
    $randpwd = '';
    for ($i = 0; $i < $pw_length; $i++) 
    {
    $randpwd .= chr(mt_rand(33, 126));
    }
    return $randpwd;
}

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname=$argv[1];

shell_exec("sudo useradd {$uname} -m -s/bin/bash");
shell_exec("sudo usermod -G {$uname} -a www-data");
shell_exec("sudo setquota -u {$uname} " . ($rpDiskLimitMB*1000) . " " . ($rpDiskLimitMB * 1000 * 1.5) . " 0 0 -a");
shell_exec("sudo echo 'source /etc/profile.d/rvm.sh' | sudo tee -a /home/{$uname}/.bashrc");

$conn=new lpMySQL;
$conn->exec("CREATE USER '%s'@'localhost' IDENTIFIED BY '%s';",$uname,create_password(30));
$conn->exec("GRANT ALL PRIVILEGES ON  `%s\_%%` . * TO  '%s'@'localhost';",$uname,$uname);

