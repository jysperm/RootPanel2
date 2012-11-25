#!/usr/bin/php
<?php

$psArray = array();

function execPs()
{
    global $psArray;
    
    if(count($psArray) >= 12)
        array_shift($psArray);
    
    $psResult=shell_exec("ps xufwa");
    $psList=explode("\n",$psInfo);
    array_shift($psList);
    
    $psArray[]=$psList;
}

while(true)
{
    
    
    
    sleep(10);
}
