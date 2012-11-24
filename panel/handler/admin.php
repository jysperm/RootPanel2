<?php

class LoginAsAction extends lpAction
{
    public function loginas()
    {
        if(!isset($_GET["uname"]) || !isset($_GET["passwd"]))
        {
            lpRoute::quit("参数不全");
        }
        else
        {
            lpAuth::login($_GET["uname"],$_GET["passwd"],false,false,true);
            lpRoute::gotoUrl("/panel/");
        }
    }
}

class AdminPage extends lpPage
{
    public function get()
    {
        global $rpAdminUsers,$rpROOT;
    
        if(!lpAuth::login() || !in_array(lpAuth::getUName(),$rpAdminUsers))
        {
            lpRoute::gotoUrl("/login/");
            exit();
        }
            
        lpTemplate::outputFile("{$rpROOT}/template/admin.php");
    }
}

class AdminAction extends lpAction
{
    private $conn;
    
    public function _Init()
    {
        global $rpAdminUsers;
        $this->conn=new lpMySQL;
        
        if(!lpAuth::login() || !in_array(lpAuth::getUName(),$rpAdminUsers))
            lpRoute::quit("未登录或不是管理员");
    }
    
    public function addtime()
    {
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();
        
        $expired=(intval($rs->expired) + (intval($_POST["day"])*3600*24));
        $this->conn->update("user",array("uname"=>$_POST["uname"]),array("expired"=>$expired));
        makeLog($_POST["uname"],"被增加了{$_POST["day"]}天的使用时长");
        
        echo json_encode(array("status"=>"ok"));
    }
    
    public function getlog()
    {
        $rsL=$this->conn->select("log",array("uname"=>$_POST["uname"]),"time",-1,100,false);
        ?>
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>id</th><th>ip(UA)</th><th>时间</th><th>内容</th>
            </tr>
          </thead>
          <tbody>
            <? while($rsL->read()): ?>
              <tr>
                <td><?= $rsL->id;?></td><td><span title="<?= str_replace("\"","",$rsL->ua);?>"><?= $rsL->ip;?></span></td>
                <td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= htmlspecialchars($rsL->content);?></td>
              </tr> 
            <? endwhile; ?>
          </tbody>
        </table>
        <?php
    }
    
    public function delete()
    {
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();
        if($rs->type="no")
        {
            $this->conn->delete("user",array("uname"=>$_POST["uname"]));
            makeLog($_POST["uname"],"被删除");
            echo json_encode(array("status"=>"ok"));
        }
        else
        {
            jsonError("请先转为未付费");
        }
    }
    
    public function alertpay()
    {
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();

        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机即将到期提醒 - {$rs->uname}将于". lpTools::niceTime($rs->expired) . "到期";
        $mailBody=$mailTitle;
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
        
        makeLog($_POST["uname"],$mailBody);
        
        echo json_encode(array("status"=>"ok"));
    }
    
    public function alertdelete()
    {
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();

        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机即将删除提醒 - {$rs->uname}已于". lpTools::niceTime($rs->expired) . "到期";
        $mailBody=$mailTitle;
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
      
        makeLog($_POST["uname"],$mailBody);
        
        echo json_encode(array("status"=>"ok"));
    }
    
    public function tostd()
    {
        global $rpROOT;
      
        shell_exec("{$rpROOT}/../core/creat-account.php {$_POST['uname']}");
        
        $this->conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"std"));
        
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();

        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机开通提醒"; 
        $mailBody="{$_POST["uname"]}-RP主机开通提醒(标准付费版)"; 
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
        
        makeLog($_POST["uname"],"被开通为标准付费用户");
        
        echo json_encode(array("status"=>"ok"));
    }
    
    public function toext()
    {
        global $rpROOT;
        
        shell_exec("{$rpROOT}/../core/creat-account.php {$_POST['uname']}");
        
        $this->conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"ext"));
        
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();
        
        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机开通提醒"; 
        $mailBody="{$_POST["uname"]}-RP主机开通提醒(额外技术支持版)"; 
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
        
        makeLog($_POST["uname"],"被开通为额外技术支持用户");
        
        echo json_encode(array("status"=>"ok"));
    }
    
    public function tofree()
    {
        global $rpROOT;
        
        shell_exec("{$rpROOT}/../core/creat-account.php {$_POST['uname']}");
        
        $this->conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"free"));
        
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();
        
        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机开通提醒"; 
        $mailBody="{$_POST["uname"]}-RP主机开通提醒(免费试用)"; 
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
        
        makeLog($_POST["uname"],"被开通为免费试用用户");
        
        echo json_encode(array("status"=>"ok"));
    }
            
    public function tono()
    {
        global $rpROOT;
        
        shell_exec("{$rpROOT}/../core/delete-account.php {$_POST['uname']} sure");
        
        $this->conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"no"));
        
        $rs=$this->conn->select("user",array("uname"=>$_POST["uname"]));
        $rs->read();
        
        $mailer=new lpSmtpMail();

        $mailTitle="{$_POST["uname"]}-RP主机被转为未付费"; 
        $mailBody=$mailTitle;
        
        $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
        
        makeLog($_POST["uname"],"被删除用户");
        
        echo json_encode(array("status"=>"ok"));
    }
}

?>
