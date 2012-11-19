<?php

class Panel extends lpPage
{
    public function get()
    {
        global $rpROOT;
        
        global $rpAdminUsers;
        
        if(!lpAuth::login())
        {
            gotoUrl("/login/");
            exit();
        }
        if(isAllowPanel(lpAuth::getUName()))
        {
            lpTemplate::parseFile("{$rpROOT}/template/panel.php");
        }
        else
        {
            if(in_array(lpAuth::getUName(),$rpAdminUsers))
            {
                gotoUrl("/admin/");
                exit();
            }
            gotoUrl("/pay/");
        }
    }
}

class RequestAction extends lpAction
{
    public function request()
    {
        global $rpAdminEmail;
        
        if(!lpAuth::login())
            lpMVC::quit("未登录");
        if(!isset($_POST["content"]))
            lpMVC::quit("参数不全");
        
        $mailer=new lpSmtpMail();
        $conn=new lpMySQL;
        $rs=$conn->select("user",array("uname"=>lpAuth::getUName()));
        $rs->read();

        $mailTitle=lpAuth::getUName() . "-RP主机试用申请"; 
        $mailBody="{$rs->email}\n\n" . $_POST["content"];
        
        $mailer->send($rpAdminEmail,$mailTitle,$mailBody);
        
        makeLog(lpAuth::getUName(),"填写试用申请" . $_POST["content"]);
        
        echo json_encode(array("status"=>"ok"));
    }
}

class VirtualHost extends lpAction
{
    private $conn;
    
    var $msg;
    var $row;
    
    public function _Init()
    {
        $this->conn=new lpMySQL;
        if(!lpAuth::login() || !isAllowPanel(lpAuth::getUName()))
        {
            lpMVC::quit("未登录或未付费");
        }
    }

    public function get()
    {
        global $rpROOT;
        
        if(!isset($_POST["id"]))
            lpMVC::quit("参数不全");
        
        $uname=lpAuth::getUName();
        $rs=$this->conn->select("virtualhost",array("id"=>$_POST["id"]));
        if($rs->read() && $rs->uname==$uname)
        {
              $tmp=new lpTemplate;
              $tmp->parse("{$rpROOT}/template/edit-website.php",array("rs"=>$rs->rawArray()));
        }
        else
        {
            lpMVC::quit("站点ID不存在或站点不属于你");
        }
    }

    public function getnew()
    {
        global $rpROOT;
        
        $tmp=new lpTemplate;
        $tmp->parse("{$rpROOT}/template/edit-website.php",array("new"=>true));
    }
    
    public function delete()
    {
        global $rpROOT;
      
        if(!isset($_POST["id"]))
            lpMVC::quit("参数不全");
        
        $rs=$this->conn->select("virtualhost",array("id"=>$_POST["id"]));
        if($rs->read() && $rs->uname==lpAuth::getUName())
        {
            $cfgOld=json_encode($rs->rawArray());
            makeLog(lpAuth::getUName(),"删除了站点{$rs->id}，配置为{$cfgOld}");
            
            $this->conn->delete("virtualhost",array("id"=>$_POST["id"]));
            shell_exec("{$rpROOT}/../core/web-conf-maker.php {$rs->uname}");
          
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError("站点ID不存在或站点不属于你");
        }
    }
    
    public function edit()
    {
        global $lpCfgTimeToChina,$rpROOT;
        
        if(!isset($_POST["id"]))
            lpMVC::quit("参数不全");
        
        $rs=$this->conn->select("virtualhost",array("id"=>$_POST["id"]));
        if($rs->read() && $rs->uname==lpAuth::getUName())
        {
            if($this->checkInput())
            {
                $row=$this->row;
                $row["lastchange"]=time()+$lpCfgTimeToChina;
                $cfgOld=json_encode($rs->rawArray());
                $cfgNew=json_encode($row);
                
                makeLog(lpAuth::getUName(),"修改了站点{$rs->id}，原配置为：{$cfgOld},新配置为{$cfgNew}");
                
                $this->conn->update("virtualhost",array("id"=>$_POST["id"]),$row);
                shell_exec("{$rpROOT}/../core/web-conf-maker.php " . lpAuth::getUName());
                
                echo json_encode(array("status"=>"ok"));
            }
            else
            {
                jsonError($this->msg);
            }
        }
        else
        {
            jsonError("站点ID不存在或站点不属于你");
        }
    }
    
    public function add()
    {
        global $lpCfgTimeToChina,$rpROOT;
        
        if($this->checkInput(true))
        {
            $row=$this->row;
            $row["time"]=time()+$lpCfgTimeToChina;
            $row["ison"]=1;
            $row["uname"]=lpAuth::getUName();
            $row["lastchange"]=time()+$lpCfgTimeToChina;
            $cfgNew=json_encode($row);
            
            makeLog(lpAuth::getUName(),"创建了站点{$this->conn->insertId()}，配置为：{$cfgNew}");
            
            $this->conn->insert("virtualhost",$row);
            shell_exec("{$rpROOT}/../core/web-conf-maker.php " . lpAuth::getUName());
            
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError($this->msg);
        }
    }
    
    public function sshpasswd()
    {
        if(!isset($_POST["passwd"]))
            lpMVC::quit("参数不全");
            
        if(preg_match('/^[A-Za-z0-9\-_]+$/',$_POST["passwd"]))
        {
            $unmae=lpAuth::getUName();
            shell_exec("echo '{$unmae}:{$_POST['passwd']}' | sudo chpasswd");
            
            makeLog(lpAuth::getUName(),"修改了SSH密码");
            
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError("密码不合法");
        }
    }

    public function mysqlpasswd()
    {
        if(!isset($_POST["passwd"]))
            lpMVC::quit("参数不全");
            
        if(preg_match('/^[A-Za-z0-9\-_]+$/',$_POST["passwd"]))
        {
            $uname=lpAuth::getUName();
            
            $this->conn->exec("SET PASSWORD FOR '%s'@'localhost' = PASSWORD('%s');",$uname,$_POST["passwd"]);
            
            makeLog(lpAuth::getUName(),"修改了MySQL密码");
            
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError("密码不合法");
        }
    }
    
    public function panelPasswd()
    {
        if(isset($_POST["passwd"]))
        {
            $uname=lpAuth::getUName();

            $this->conn->update("user",array("uname"=>$uname),array("passwd"=>lpAuth::DBHash($uname,$_POST["passwd"])));
            
            makeLog(lpAuth::getUName(),"修改了面板密码");
            
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError("密码不合法");
        }
    }
  
    private function checkInput($isNew=false)
    {
        // domains-域名
        // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
        // ^ *DOMAIN( DOMAIN)* *$
        if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',
           $_POST["domains"]) || strlen($_POST["domains"]) > 128 )
        {
            $this->msg="域名格式不正确";
            return false;
        }
        else
        {
            $row["domains"]=strtolower(trim(str_replace("  "," ",$_POST["domains"])));
            if($isNew)
                $rsD=$this->conn->exec("SELECT * FROM `virtualhost`");
            else
                $rsD=$this->conn->exec("SELECT * FROM `virtualhost` WHERE `id` <> '%i'",$_POST["id"]);
            while($rsD->read())
            {
                $tD=explode(" ",$rsD->domains);
                $curD=explode(" ",$row["domains"]);
                if(count(array_intersect($tD,$curD)))
                {
                    $this->msg="以下域名已被其他人绑定，请联系客服：" . join(" ",array_intersect($tD,$curD));
                    return false;
                }
            }
        }
        
        // template模板类型
        if(!in_array($_POST["optemplate"],array("web","proxy","python")))
        {
            $this->msg="optemplate参数错误";
            return false;
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
                    $this->msg="别名{$vv[0]}不正确";
                    return false;
                }
                
                if(!checkFileName($vv[1]))
                {
                    $this->msg="别名{$vv[1]}不正确";
                    return false;
                }
                
                $aliasR[$vv[0]]=$vv[1];
            }
        }
        
        $row["alias"]=json_encode($aliasR);
        
        // 日志
        if(!checkFileName($_POST["nginxaccess"]))
        {
            $this->msg="nginxaccess不正确";
            return false;
        }
        
        if(!checkFileName($_POST["nginxerror"]))
        {
            $this->msg="nginxerror不正确";
            return false;
        }
        
        if(!checkFileName($_POST["apacheaccess"]))
        {
            $this->msg="apacheaccess不正确";
            return false;
        }
        
        if(!checkFileName($_POST["apacheerror"]))
        {
            $this->msg="apacheerror不正确";
            return false;
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
                $this->msg="sslcrt不正确或不存在";
                return false;
            }
            
            if(!checkFileName($_POST["sslkey"]) || !file_exists($_POST["sslkey"]))
            {
                $this->msg="sslkey不正确或不存在";
                return false;
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
            case "web": 
                switch($_POST["optype"])
                {
                    case "all": 
                    break;
                    case "only":
                        // [A-Za-z0-9_\-\.]*
                        // ^ *DOMAIN( DOMAIN)* *$
                        // ^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]+)* *$
                        
                        if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["php"]) ||
                           strlen($_POST["php"]) >256 )
                        {
                            $this->msg="php格式不正确";
                            $isOk=false;
                            break;
                        }
                        
                        if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["cgi"]) ||
                           strlen($_POST["cgi"]) >256 )
                        {
                            $this->msg="cgi格式不正确";
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
                    case "unless":
                        if(!preg_match('/^ *[A-Za-z0-9_\-\.]*( [A-Za-z0-9_\-\.]*)* *$/',$_POST["static"]) ||
                           strlen($_POST["static"]) >256 )
                        {
                            $this->msg="static格式不正确";
                            return false;
                        }
                        $row["static"]=$_POST["static"];
                    break;
                    default:
                        $this->msg="参数错误";
                        return false;
                }
                
                $row["type"]=$_POST["optype"];
                
                // [A-Za-z0-9_\-\.]+
                // ^ *DOMAIN( DOMAIN)* *$
                // ^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$
                if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["indexs"]) ||
                       strlen($_POST["indexs"]) >256 )
                {
                    $this->msg="indexs格式不正确";
                    return false;
                }
                
                if(isset($_POST["autoindex"]) && $_POST["autoindex"]=="on")
                    $row["autoindex"]=1;
                else
                    $row["autoindex"]=0;
                      
                if(!checkFileName($_POST["root"]))
                {
                    $this->msg="root不正确";
                    return false;
                }
                
                $row["indexs"]=$_POST["indexs"];
                $row["root"]=$_POST["root"];
            break;
            case "proxy":
                if(!preg_match('%^http://[^\s]*$%',$_POST["root"]) ||
                   strlen($_POST["indexs"]) >512 )
                {
                    $this->msg="url格式不正确";
                    return false;
                }
                
                $row["root"]=$_POST["root"];
            break;
            case "python":
                if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["pyindexs"]) ||
                   strlen($_POST["pyindexs"]) >256 )
                {
                    $this->msg="pyindexs格式不正确";
                    return false;
                }
                
                if(isset($_POST["pyautoindex"]) && $_POST["pyautoindex"]=="on")
                    $row["autoindex"]=1;
                else
                    $row["autoindex"]=0;
                
                if(!checkFileName($_POST["root"]))
                {
                    $this->msg="root不正确";
                    return false;
                }
                
                $row["indexs"]=$_POST["pyindexs"];
                $row["root"]=$_POST["root"];
            break;
            default:
                $this->msg="参数错误";
                return false;
        }
        
        $this->row=$row;
        
        return true;
    }
}

?>
