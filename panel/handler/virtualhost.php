<?php

require_once("handler/global.php");

class VirtualHost extends lpPage
{
    private function checkInput()
    {
        
    }
  
    public function post()
    {
        global $lpCfgTimeToChina;
        
        if(!lpAuth::login())
        {
            echo "未登录";
            return true;
        }
      
        if(!isset($_POST["do"]))
        {
            echo "参数不全";
            return true;
        }
        
        $conn=new lpMySQL;
        
        switch($_POST["do"])
        {
            case "get": //获取编辑表单
                if(!isset($_POST["id"]))
                {
                    echo "参数不全";
                    return true;
                }
                else
                {
                    $rs=$conn->select("virtualhost",array("id"=>$_POST["id"]));
                    if($rs->read() && $rs->uname==lpAuth::getUName())
                    {
                          $tmp=new lpTemplate;
                          $tmp->parse("template/edit-website.php",array("rs"=>$rs->rawArray()));
                          return true;
                    }
                    else
                    {
                        echo "id不存在或ID不合法";
                        return true;
                    }
                }
            case "edit": //提交编辑
                while(true)
                {
                    $isOk=true;
                  
                    if(!isset($_POST["id"]))
                    {
                        $r["msg"]="参数不全";
                        break;
                    }
                    
                    $rs=$conn->select("virtualhost",array("id"=>$_POST["id"]));
                    if($rs->read() && $rs->uname==lpAuth::getUName() && $rs->type!="no")
                    {
                        // domains-域名
                        // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
                        // ^ *DOMAIN( DOMAIN)* *$
                        if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',
                           $_POST["domains"]) || strlen($_POST["domains"]) > 128 )
                        {
                            $r["msg"]="域名格式不正确";
                            break;
                        }
                        else
                        {
                            $row["domains"]=strtolower(trim(str_replace("  "," ",$_POST["domains"])));
                            $rsD=$conn->exec("SELECT * FROM `virtualhost` WHERE `id` <> '%i'",$_POST["id"]);
                            while($rsD->read())
                            {
                                $tD=explode(" ",$rsD->domains);
                                if(count(array_intersect($tD,$row["domains"])))
                                {
                                    $r["msg"]="以下域名已被其他人绑定，请联系客服：" . join(" ",array_intersect($tD,$row["domains"]));
                                    $isOk=false;
                                }
                            }
                            
                            if(!$isOk)
                              break;
                        }
                        
                        // template模板类型
                        if(!in_array($_POST["optemplate"],array("web","proxy","python")))
                        {
                            $r["msg"]="optemplate参数错误";
                            break;
                        }
                        
                        $row["template"]=$_POST["optemplate"];
                        
                        // Alias别名
                        $aliasR=array();
                        $alias=explode("\n",$_POST["alias"]);
                        foreach($alias as $v)
                        {
                            $vv=explode(" ",trim(str_replace("  "," ",$v)));
                            
                            if(isset($vv[0]) && isset($vv[1]) && $vv[0] && $vv[1])
                            {
                            
                                if(!preg_match('/^\S+$/',$vv[0]) || strlen($vv[0]) > 128 )
                                {
                                    $r["msg"].="别名{$vv[0]}不正确";
                                    break;
                                }
                                
                                if(!checkFileName($vv[1]))
                                {
                                    $r["msg"].="别名{$vv[1]}不正确";
                                    break;
                                }
                                
                                $aliasR[$vv[0]]=$vv[1];
                            }
                        }
                        
                        $row["alias"]=json_encode($aliasR);
                        
                        // 日志
                        if(!checkFileName($_POST["nginxaccess"]))
                        {
                            $r["msg"].="nginxaccess不正确";
                            break;
                        }
                        
                        if(!checkFileName($_POST["nginxerror"]))
                        {
                            $r["msg"].="nginxerror不正确";
                            break;
                        }
                        
                        if(!checkFileName($_POST["apacheaccess"]))
                        {
                            $r["msg"].="apacheaccess不正确";
                            break;
                        }
                        
                        if(!checkFileName($_POST["apacheerror"]))
                        {
                            $r["msg"].="apacheerror不正确";
                            break;
                        }
                        
                        $row["nginxaccess"]=$_POST["nginxaccess"];
                        $row["nginxerror"]=$_POST["nginxerror"];
                        $row["apacheaccess"]=$_POST["apacheaccess"];
                        $row["apacheerror"]=$_POST["apacheerror"];
                        
                        // SSL
                        if(isset($_POST["isssl"]) && $_POST["isssl"]=="on")
                        {
                            if(!checkFileName($_POST["sslcrt"]) || !file_exists($_POST["sslcrt"]))
                            {
                                $r["msg"]="sslcrt不正确或不存在";
                                break;
                            }
                            
                            if(!checkFileName($_POST["sslkey"]) || !file_exists($_POST["sslkey"]))
                            {
                                $r["msg"]="sslkey不正确或不存在";
                                break;
                            }
                            
                            $row["isssl"]=1;
                            $row["sslcrt"]=$_POST["sslcrt"];
                            $row["sslkey"]=$_POST["sslkey"];
                        }
                        else
                        {
                            $row["isssl"]=0;
                        }
                        
                        // 核心选项
                        switch($_POST["optemplate"])
                        {
                            //常规Web
                            case "web": 
                                switch($_POST["optype"])
                                {
                                    //全部转发到Apache
                                    case "all": 
                                    break;
                                    
                                    //仅指定转发到Apache
                                    case "only":
                                    // [A-Za-z0-9_\-\.]*
                                    // ^ *DOMAIN( DOMAIN)* *$
                                    // ^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]+)* *$
                                    
                                    
                                    if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["php"]) ||
                                       strlen($_POST["php"]) >256 )
                                    {
                                        $r["msg"]="php格式不正确";
                                        $isOk=false;
                                        break;
                                    }
                                    
                                    if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["cgi"]) ||
                                       strlen($_POST["cgi"]) >256 )
                                    {
                                        $r["msg"]="cgi格式不正确";
                                        $isOk=false;
                                        break;
                                    }
                                    
                                    if(isset($_POST["is404"]) && $_POST["is404"]=="on")
                                        $row["is404"]=1;
                                    else
                                        $row["is404"]=0;
                                    
                                    $row["php"]=$_POST["php"];
                                    $row["cgi"]=$_POST["cgi"];
                                    
                                    break;
                                    
                                    // 仅指定不转发
                                    case "unless":
                                    
                                    if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["static"]) ||
                                       strlen($_POST["static"]) >256 )
                                    {
                                        $r["msg"]="static格式不正确";
                                        $isOk=false;
                                        break;
                                    }
                                    $row["static"]=$_POST["static"];
                                    
                                    break;
                                    
                                    
                                    default:
                                        $r["msg"]="参数错误";
                                        $isOk=false;
                                }
                                
                                $row["type"]=$_POST["optype"];
                                
                                // [A-Za-z0-9_\-\.]+
                                // ^ *DOMAIN( DOMAIN)* *$
                                // ^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$
                                if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["indexs"]) ||
                                       strlen($_POST["indexs"]) >256 )
                                {
                                    $r["msg"]="indexs格式不正确";
                                    $isOk=false;
                                    break;
                                }
                                
                                if(isset($_POST["autoindex"]) && $_POST["autoindex"]=="on")
                                    $row["autoindex"]=1;
                                else
                                    $row["autoindex"]=0;
                                      
                                if(!checkFileName($_POST["root"]))
                                {
                                    $r["msg"]="root不正确";
                                    $isOk=false;
                                    break;
                                }
                                
                                
                                $row["indexs"]=$_POST["indexs"];
                                $row["root"]=$_POST["root"];
                            
                            break;
                            
                            
                            case "proxy":
                            if(!preg_match('%^http://[^\s]*$%',$_POST["root"]) ||
                                       strlen($_POST["indexs"]) >512 )
                                {
                                    $r["msg"]="url格式不正确";
                                    $isOk=false;
                                    break;
                                }
                                
                                $row["root"]=$_POST["root"];
                            
                            break;
                            case "python":
                            
                            
                            if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["pyindexs"]) ||
                                       strlen($_POST["pyindexs"]) >256 )
                                {
                                    $r["msg"]="pyindexs格式不正确";
                                    $isOk=false;
                                    break;
                                }
                                
                                if(isset($_POST["pyautoindex"]) && $_POST["pyautoindex"]=="on")
                                    $row["autoindex"]=1;
                                else
                                    $row["autoindex"]=0;
                                
                                if(!checkFileName($_POST["root"]))
                                {
                                    $r["msg"].="root不正确";
                                    $isOk=false;
                                    break;
                                }
                                
                                $row["indexs"]=$_POST["pyindexs"];
                                $row["root"]=$_POST["root"];
                            break;
                            default:
                                $r["msg"]="参数错误";
                                $isOk=false;
                        }
                        
                        if(!$isOk)
                            break;
                        
                        $row["lastchange"]=time()+$lpCfgTimeToChina;
                        $cfgOld=json_encode($rs->rawArray());
                        $cfgNew=json_encode($row);
                        makeLog(lpAuth::getUName(),"修改了{$rs->id}的配置，原配置为：{$cfgOld},新配置为{$cfgNew}");
                        
                        $conn->update("virtualhost",array("id"=>$_POST["id"]),$row);
                    }
                    else
                    {
                        $r["msg"]="id不存在,或未续费";
                        break;
                    }
                    break;
                }
                
                if(isset($r["msg"]))
                    $r["status"]="error";
                else
                    $r["status"]="ok";
                echo json_encode($r);
                return true;
                break;
            case "getnew":
                $tmp=new lpTemplate;
                $tmp->parse("template/edit-website.php",array("new"=>true));
                return true;
                break;
            case "new":
            default:
                echo "参数错误";
                return true;
        }
    }
}

?>
