#!/usr/bin/php
<?php

require_once("../LightPHP/lp-load.php");
require_once("../panel/config.php");

if(!isset($argv[1]))
    die("error : {$argv[0]} <uname>\n");
$uname=$argv[1];

lpLoader("lpTemplate");

$conn=new lpMySQL;
$rsU=$conn->select("user",array("uname"=>$uname));
$rsV=$conn->select("virtualhost",array("uname"=>$uname));

$out="# " . gmdate("Y.m.d H:i:s",time() + $lpCfgTimeToChina) . "\n";
while($rsV->read())
{
    lpBeginBlock();
    $tmp = new lpTemplate;
    $a["v"]=$rsV->rawArray();
    $tmp->parse("conf-template/nginx.php",$a);
    $out.=lpEndBlock();
}

echo $out;


?>
