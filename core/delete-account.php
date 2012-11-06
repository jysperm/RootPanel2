#!/usr/bin/php
<?php
if(!isset($argv[1]) || !isset($argv[2]) || $argv[2]!="sure")
    die("error : {$argv[0]} <uname> sure\n");
$uname=$argv[1];

shell_exec("sudo userdel -r {$uname}");
shell_exec("sudo groupdel {$uname}");

?>
