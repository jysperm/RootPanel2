#!/usr/bin/php
<?php

require_once("/RootPanel/LightPHP/lp-load.php");
require_once("/RootPanel/panel/config.php");

lpLoader("lpLock");
lpLoader("lpTemplate");

$l=new lpMutex;

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname=$argv[1];

$conn=new lpMySQL;
$rsU=$conn->select("user",array("uname"=>$uname));
$rsV=$conn->select("virtualhost",array("uname"=>$uname));

// Nginx

$out="# " . gmdate("Y.m.d H:i:s",time() + $lpCfgTimeToChina) . "\n";
while($rsV->read())
{
    lpBeginBlock();
    $tmp = new lpTemplate;
    $a["v"]=$rsV->rawArray();
    $tmp->parse("{$rpROOT}/../core/conf-template/nginx.php",$a);
    $out.=lpEndBlock();
}
$out.=$rsU->extconfnginx."\n";

file_put_contents("{$rpROOT}/temp",$out);
shell_exec("sudo cp {$rpROOT}/temp /etc/nginx/sites-enabled/{$uname}");
shell_exec("sudo chown root:root /etc/nginx/sites-enabled/{$uname}");
shell_exec("sudo chmod 700 /etc/nginx/sites-enabled/{$uname}");

// Apache2
$rsV=$conn->select("virtualhost",array("uname"=>$uname));
$out="# " . gmdate("Y.m.d H:i:s",time() + $lpCfgTimeToChina) . "\n";
while($rsV->read())
{
    lpBeginBlock();
    $tmp = new lpTemplate;
    $a["v"]=$rsV->rawArray();
    $tmp->parse("{$rpROOT}/../core/conf-template/apache2.php",$a);
    $out.=lpEndBlock();
}
$out.=$rsU->extconfapache."\n";

file_put_contents("{$rpROOT}/../temp",$out);
shell_exec("sudo cp {$rpROOT}/../temp /etc/apache2/sites-enabled/{$uname}");
shell_exec("sudo chown root:root /etc/apache2/sites-enabled/{$uname}");
shell_exec("sudo chmod 700 /etc/apache2/sites-enabled/{$uname}");
shell_exec("rm {$rpROOT}/../temp");

shell_exec("sudo service nginx reload");
shell_exec("sudo service apache2 reload");

$l=NULL;
