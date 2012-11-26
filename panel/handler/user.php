<?php

lpLoader("lpPage");

class Signup extends lpPage
{
    public function get()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/signup.php");
    }

    public function post()
    {
        global $lpCfgTimeToChina,$rpNotAllowReg,$rpROOT;
        
        if(!isset($_POST["uname"]) or !isset($_POST["email"]))
            $this->procError("请将信息填写完整");
        
        if(!preg_match('/[A-Za-z][A-Za-z0-9_]+/u',$_POST["uname"]) or
           !preg_match('/[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+/',$_POST["email"]))
        {
            lpTemplate::beginBlock();?>
              <ul>
                <li>帐号仅可以使用英文、数字、下划线,且第一个字符必须为英文字母</li>
                <li>邮箱务必为正确的邮箱地址</li>
              </ul>
            <?php
            $this->procError(lpTemplate::endBlock());
        }
        
        if(in_array($_POST["uname"],$rpNotAllowReg))
            $this->procError("该用户名不允许注册");

        $conn=new lpMySQL;

        $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
        if($rs->read())
            $this->procError("帐号已存在");

        $row["uname"]=$_POST["uname"];
        $row["passwd"]=lpAuth::DBHash($_POST["uname"],$_POST["passwd"]);
        $row["email"]=$_POST["email"];
        $row["regtime"]=time()+$lpCfgTimeToChina;
        $row["type"]="no";
        $row["pptppasswd"]="";
        $row["expired"]=time()+$lpCfgTimeToChina-1;

        $conn->insert("user",$row);
        
        lpAuth::login($row["uname"],$row["passwd"],false,true);
        
        makeLog($_POST["uname"],"注册了帐号");
        
        lpRoute::gotoUrl("/panel/");
    }
    
    public function procError($str)
    {
        global $rpROOT;
        
        $this->httpCode=400;
        $tmp=new lpTemplate("{$rpROOT}/template/signup.php");
        
        $tmp->errorMsg=$str;
        $tmp->uname=$_POST["uname"];
        $tmp->email=$_POST["email"];
            
        $tmp->output();
        
        exit();
    }
}

class Login extends lpPage
{
    public function get()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/login.php");
    }
    
    public function post()
    {
        if(!isset($_POST["uname"]) or !isset($_POST["passwd"]))
            $this->procError("请输入账号和密码");
        
        if(lpAuth::login($_POST["uname"],$_POST["passwd"]))
            lpRoute::gotoUrl(isset($_GET["next"])?$_GET["next"]:"/panel/");
        else
            $this->procError("用户名或密码错误");
    }
    
    public function procError($str)
    {
        global $rpROOT;
        
        $this->httpCode=400;
        $tmp=new lpTemplate("{$rpROOT}/template/login.php");
        
        $tmp->errorMsg=$str;
        $tmp->uname=$_POST["uname"];
            
        $tmp->output();
        
        exit();
    }
}

class Logout extends lpPage
{
    public function get()
    {
        lpAuth::logout();
        lpRoute::gotoUrl("/");
    }
}

?>
