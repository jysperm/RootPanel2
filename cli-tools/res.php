#!/usr/bin/php
<?php

define("lpOFF_Exception",true);

require_once("/RootPanel/LightPHP/lp-load.php");
require_once("/RootPanel/panel/main-config.php");

//旧的快照在前，新的在后
$psArray = array();

function execPs()
{
    global $psArray;
    
    if(count($psArray) >= 12)
        array_shift($psArray);
    
    $psResult=shell_exec("ps xufwa");
    $psList=explode("\n",$psResult);
    array_shift($psList);
    array_pop($psList);
    
    foreach($psList as &$v)
    {
        while(stripos($v,"  "))
        {
            $v=str_replace("  "," ",$v);
        }
        $v=explode(" ",$v,11);
    }
    
    foreach($psList as $v)
    {
        if(intval($v[5])>0)
        {
            $item["user"]=$v[0];
            $item["pid"]=$v[1];
            $item["cpu"]=$v[2];
            $item["mem"]=$v[3];
            $item["vsz"]=$v[4];
            $item["rss"]=$v[5];
            $item["tty"]=$v[6];
            $item["stat"]=$v[7];
            $item["start"]=$v[8];
            $item["time"]=$v[9];
            $item["command"]=$v[10];
            
            $tList[]=$item;
        }
    }
    $psList=$tList;
    
    print_r($psList);
    
    $psArray[]=$psList;
}

while(true)
{
    execPs();   //采集信息到$psArray
    
    //检查CPU占用
    
    //检查内存占用
    
    sleep(10);
}
