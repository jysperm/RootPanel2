<?php

class rpTools
{
    const NO = "no";

    static public function gravatarURL($email, $size=80)
    {
        global $rpCfg;
        return $rpCfg["GravaterURL"] . md5(strtolower(trim($email))) . "?s={$size}";
    }

    static public function makeLog($user, $description, $detail, $by=null)
    {
        global $lpApp;
        $q = new lpDBQuery($lpApp->getDB());

        $row = [
            "uname" => $user,
            "time" => time(),
            "description" => $description,
            "detail" => $detail,
            "by" => $by ? $by : $user,
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "ip" => rpTools::getIP()
        ];

        $q("log")->insert($row);
    }

    public static function getIP()
    {
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        else
            return $_SERVER["REMOTE_ADDR"];
    }
}

/*
function cbLogin($user)
{
    global $lpCfgTimeToChina;

    $row["lastlogintime"]=time()+$lpCfgTimeToChina;
    $row["lastloginip"]=lpTools::getIP();
    $row["lastloginua"]=$_SERVER["HTTP_USER_AGENT"];
    
    $conn=new lpMySQL;
    $conn->update("user",array("uname"=>$user),$row);
}

function jsonError($str)
{
    $r["msg"]=$str;
    $r["status"]="error";
    echo json_encode($r);
    exit();
}

function isAllowPanel($uname)
{
    global $rpAdminUsers;
  
    $conn=new lpMySQL;
    $rs=$conn->select("user",array("uname"=>$uname));
    if($rs->read())
        if($rs->type!="no" && !in_array($uname,$rpAdminUsers))
            return true;

    return false;
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
    $row["ua"]=$_SERVER["HTTP_USER_AGENT"];
    $row["ip"]=lpTools::getIP();;
    $row["content"]=$content;

    $conn->insert("log",$row);
}

$uiTemplate=array("web"=>"常规Web(PHP等CGI)",
                  "proxy"=>"反向代理",
                  "python"=>"Python(WSGI模式)");
$uiHander=array("web"=>"Web根目录",
                "proxy"=>"反向代理URL",
                "python"=>"根目录处理器");
$uiType=array("all"=>"全部转到Apache",
              "only"=>"仅转发指定的URL(一般是脚本文件)",
              "unless"=>"不转发指定的URL(一般是静态文件)");
              
$uiUserType=array("no"=>"未购买",
                  "free"=>"免费试用版",
                  "std"=>"标准付费版",
                  "ext"=>"额外技术支持版");


?>
*/