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

?>
