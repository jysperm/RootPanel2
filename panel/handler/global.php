<?php

function cbLogin($user)
{
    global $lpCfgTimeToChina;

    $row["lastlogintime"]=time()+$lpCfgTimeToChina;
    $row["lastloginip"]=lpTools::getIP();
    $row["lastloginua"]=$_SERVER["HTTP_USER_AGENT"];
    
    $conn=new lpMySQL;
    $conn->update("user",array("uname"=>$user),$row);
}

function gotoUrl($url)
{
    header("Location: {$url}");
}

function makeLog($uname,$content)
{
    global $lpCfgTimeToChina;
  
    $conn=new lpMySQL;
    
    $row["uname"]=$uname;
    $row["time"]=time()+$lpCfgTimeToChina;
    $row["content"]=$content;

    $conn->insert("log",$row);
}

?>
