#!/usr/bin/php
<?php

require_once("/RootPanel/LightPHP/lp-load.php");
require_once("/RootPanel/panel/config.php");


if(!isset($argv[1]) || !isset($argv[2]) || $argv[2]!="sure")
    die("error : {$argv[0]} <uname> sure\n");
$uname=$argv[1];

shell_exec("sudo userdel -r {$uname}");
shell_exec("sudo groupdel {$uname}");

$conn=new lpMySQL;
$conn->exec("DROP USER '%s'@'localhost';",$uname);

$dbs=$conn->getDBs();
foreach($dbs as $i)
{
    echo $i;
    if(substr($i,0,strlen($uname))==$uname)
    {
        $conn->exec("DROP DATABASE `%s`;",$i);
        
    }
}

?>
