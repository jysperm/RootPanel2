<?php

class AdminAction extends lpAction
{
    
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
      
        shell_exec("{$rpROOT}/../cli-tools/creat-account.php {$_POST['uname']}");
        
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
        
        shell_exec("{$rpROOT}/../cli-tools/creat-account.php {$_POST['uname']}");
        
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
        
        shell_exec("{$rpROOT}/../cli-tools/creat-account.php {$_POST['uname']}");
        
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
        
        shell_exec("{$rpROOT}/../cli-tools/delete-account.php {$_POST['uname']} sure");
        
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
