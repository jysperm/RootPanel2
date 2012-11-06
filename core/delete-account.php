#!/usr/bin/php
<?php
if(!isset($argv[1]) || !isset($argv[2]) || $argv[1]!="sure")
    die("error : {$argv[0]} <uname> sure\n");
$uname=$argv[1];

shell_exec("userdel -r {uname}");
shell_exec("groupdel {$uname}");

?>
