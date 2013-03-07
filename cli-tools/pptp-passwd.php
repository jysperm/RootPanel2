#!/usr/bin/php
<?php

require_once("/RootPanel/LightPHP/lp-load.php");
require_once("/RootPanel/panel/main-config.php");

lpLoader("lpLock");

$l=new lpMutex;

$conn=new lpMySQL;
$rs=$conn->exec("SELECT * FROM `user` WHERE `type`!='no'");

lpTemplate::beginBlock();

while($rs->read())
{
    if($rs->pptppasswd)
        echo "{$rs->uname} * {$rs->pptppasswd} * \n";
}

file_put_contents("{$rpROOT}/temp",lpTemplate::endBlock());

shell_exec("sudo cp {$rpROOT}/temp /etc/ppp/chap-secrets");
shell_exec("sudo chown root:root /etc/ppp/chap-secrets");
shell_exec("sudo chmod 700 /etc/ppp/chap-secrets");

$l=NULL;
