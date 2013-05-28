#!/usr/bin/php
<?php

$rpROOT = dirname(__FILE__);
$rpROOT = "{$rpROOT}/../panel";

require_once("{$rpROOT}/LightPHP/lp-load.php");
require_once("{$rpROOT}/include/rpApp.php");
rpApp::helloWorld();

$lock = new lpMutex;

$db = lpFactory::get("PDO");

lpTemplate::beginBlock();

foreach($db->query("SELECT * FROM `user` WHERE `type`! ='no'") as $user)
{
    if($user["settings"]["pptppasswd"])
        echo "{$user['uname']} * {$user["settings"]["pptppasswd"]} * \n";
}

file_put_contents("/tmp/temp", lpTemplate::endBlock());

shell_exec("sudo cp /tmp/temp /etc/ppp/chap-secrets");
shell_exec("sudo chown root:root /etc/ppp/chap-secrets");
shell_exec("sudo chmod 700 /etc/ppp/chap-secrets");

shell_exec("rm /tmp/temp");

$lock = null;
