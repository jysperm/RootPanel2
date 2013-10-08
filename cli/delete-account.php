#!/usr/bin/php
<?php

define("rpROOT", dirname(__FILE__) . "/../web");

require_once(rpROOT . "/LightPHP/lp-load.php");
require_once(rpROOT . "/include/rpApp.php");
rpApp::helloWorld();

if(!isset($argv[1]) || !isset($argv[2]) || $argv[2]!="sure")
    die("error : {$argv[0]} <uname> sure\n");

$uname = $argv[1];

shell_exec("sudo userdel -rf {$uname}");
shell_exec("sudo groupdel {$uname}");
shell_exec("sudo rm -f /etc/nginx/sites-enabled/{$uname}");
shell_exec("sudo rm -f /etc/apache2/sites-enabled/{$uname}");
shell_exec("sudo rm -f /etc/php5/fpm/pool.d/{$uname}.conf");

shell_exec("sudo " . rpROOT . "/../cli/pptp-passwd.php");
shell_exec("sudo service nginx reload");
shell_exec("sudo service apache2 reload");
shell_exec("sudo kill -USR2 `cat /var/run/php5-fpm.pid`");

$db = lpFactory::get("lpDBDrive");
$db->exec(sprintf("DROP USER '%s'@'localhost';", $uname));

foreach($db->query("show databases;") as $row)
    if(substr($row["Database"], 0, strlen($uname)+1) == "{$uname}_")
        $db->exec(sprintf("DROP DATABASE `%s`;", $row["Database"]));


