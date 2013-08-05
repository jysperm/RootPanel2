#!/usr/bin/php
<?php

define("rpROOT", dirname(__FILE__) . "/../web");

require_once(rpROOT . "/LightPHP/lp-load.php");
require_once(rpROOT . "/include/rpApp.php");
rpApp::helloWorld();

$types = rpVHostType::loadTypes();

$lock = new lpMutex;

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname = $argv[1];

$db = lpFactory::get("PDO");
$user = rpUserModel::by("uname", $uname);

$config["nginx"] = $config["apache"] = "# " . gmdate("Y.m.d H:i:s") . "\n";

foreach(rpVirtualHostModel::select(["uname" => $uname]) as $host)
{
    $host = rpVirtualHostModel::jsonDecode($host);
    $conf = $types[$host["type"]]->createConfig($host);

    $tmp = new lpTemplate("{$rpROOT}/../cli/template/nginx.php");
    $tmp->setValues([
        "hosts" => $host,
        "user" => $user,
        "conf" => $conf["nginx"]
    ]);

    $config["nginx"] .= $tmp->getOutput();
    if(isset($conf["apache"]))
        $config["apache"] .= $conf["apache"];
}

$config["nginx"] .= $user["settings"]["nginxextconfig"];
$config["apache"] .= $user["settings"]["apache2extconfig"];

if($config["nginx"] != shell_exec("sudo cat /etc/nginx/sites-enabled/{$uname}"))
{
    file_put_contents("/tmp/temp", $config["nginx"]);
    shell_exec("sudo cp /tmp/temp /etc/nginx/sites-enabled/{$uname}");
    shell_exec("sudo chown root:root /etc/nginx/sites-enabled/{$uname}");
    shell_exec("sudo chmod 700 /etc/nginx/sites-enabled/{$uname}");

    shell_exec("sudo service nginx reload");
}

if($config["apache"] != shell_exec("sudo cat /etc/apache2/sites-enabled/{$uname}"))
{
    file_put_contents("/tmp/temp", $config["apache"]);
    shell_exec("sudo cp /tmp/temp /etc/apache2/sites-enabled/{$uname}");
    shell_exec("sudo chown root:root /etc/apache2/sites-enabled/{$uname}");
    shell_exec("sudo chmod 700 /etc/apache2/sites-enabled/{$uname}");

    shell_exec("sudo service apache2 reload");
}

$lock = NULL;
