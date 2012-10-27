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

function checkFileName($filename)
{
    $user=lpAuth::getUName();
    $userDir="/home/{$user}/";
    
    if(preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$filename) && 
       substr($filename,0,strlen($userDir)) == $userDir &&
       strlen($filename) < 512  &&
       substr($filename,-3) != "/.." && 
       strpos($filename,"/../") === false)
        return true;
    return false;
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

$uiTemplate=array("web"=>"常规Web(PHP等CGI)",
                  "proxy"=>"反向代理",
                  "python"=>"Python(WSGI模式)");
$uiHander=array("web"=>"Web根目录",
                "proxy"=>"反向代理URL",
                "python"=>"Web根目录");
$uiType=array("all"=>"全部转到Apache",
              "only"=>"仅转发指定的URL(一般是脚本文件)",
              "unless"=>"不转发指定的URL(一般是静态文件)");

?>
