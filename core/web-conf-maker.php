#!/usr/bin/php
<?php

require_once("../LightPHP/lp-load.php");
require_once("../panel/config.php");

$l=new lpMutex;

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname=$argv[1];

lpLoader("lpTemplate");

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
    $tmp->parse("conf-template/nginx.php",$a);
    $out.=lpEndBlock();
}
$out.=$rsU->extconfnginx."\n";

file_put_contents("./temp",$out);
shell_exec("sudo cp ./temp /etc/nginx/site-enabled/{$uname}");
shell_exec("sudo chown root:root /etc/nginx/site-enabled/{$uname}");
shell_exec("sudo chmod 700 /etc/nginx/site-enabled/{$uname}");

// Apache2

$out="# " . gmdate("Y.m.d H:i:s",time() + $lpCfgTimeToChina) . "\n";
while($rsV->read())
{
    lpBeginBlock();
    $tmp = new lpTemplate;
    $a["v"]=$rsV->rawArray();
    $tmp->parse("conf-template/apache2.php",$a);
    $out.=lpEndBlock();
}
$out.=$rsU->extconfapache."\n";

file_put_contents("./temp",$out);
shell_exec("sudo cp ./temp /etc/apache2/site-enabled/{$uname}");
shell_exec("sudo chown root:root /etc/apache2/site-enabled/{$uname}");
shell_exec("sudo chmod 700 /etc/apache2/site-enabled/{$uname}");

shell_exec("sudo service nginx reload");
shell_exec("sudo service apache2 reload");

$l=NULL;

?>
