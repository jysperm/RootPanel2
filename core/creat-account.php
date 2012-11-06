#!/usr/bin/php
<?php
if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname=$argv[1];

shell_exec("sudo useradd {$uname} -m");
shell_exec("sudo usermod -G {$uname} -a www-data");

?>
