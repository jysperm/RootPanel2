<?php

require_once("handler/global.php");

class Admin extends lpPage
{
    public function get()
    {
        if(!isset($_GET["do"]) || $_GET["do"]!="loginas" || !isset($_GET["uname"]) || !isset($_GET["passwd"]))
        {
            echo "参数不全";
            return true;
        }
        else
        {
            lpAuth::login($_GET["uname"],$_GET["passwd"],false,false,true);
            $this->gotoUrl("/panel/");
            return true;
        }
    }
    
    public function post()
    {
        global $lpCfgTimeToChina,$rpCfgMailUser,$rpCfgMailPasswd,$rpCfgMailEMail,$rpCfgMailHost;
        
        if(!lpAuth::login() || lpAuth::getUName()!="rpadmin")
        {
            echo "未登录或不是管理员";
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
            case "addtime":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                $conn->update("user",array("uname"=>$_POST["uname"]),array("expired"=> (intval($rs->expired) + (intval($_POST["day"])*3600*24))));
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "getlog":
                $rsL=$conn->select("log",array("uname"=>$_POST["uname"]),"time",-1,100,false);
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
                        <td><?= $rsL->id;?></td><td><span title="<?= str_replace("\"","",$rsL->lastloginua);?>"><?= $rsL->ip;?></span></td><td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= htmlspecialchars($rsL->content);?></td>
                      </tr> 
                    <? endwhile; ?>
                  </tbody>
                </table>
                <?php
                return true;
            break;
            case "delete":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                if($rs->type="no")
                {
                    $conn->delete("user",array("uname"=>$_POST["uname"]));
                    $r["status"]="ok";
                    echo json_encode($r);
                }
                else
                {
                    $r["status"]="error";
                    $r["msg"]="请先转为未付费";
                    echo json_encode($r);
                }
                return true;
            break;
            case "alert":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                
                $smtpserver = $rpCfgMailHost;//SMTP服务器 
                $smtpserverport = 25;//SMTP服务器端口 
                $smtpusermail = $rpCfgMailEMail;//SMTP服务器的用户邮箱 
                $smtpemailto = $rs->email;//发送给谁 
                $smtpuser = $rpCfgMailUser;//SMTP服务器的用户帐号 
                $smtppass = $rpCfgMailPasswd;//SMTP服务器的用户密码 
                
                
                $mailsubject =  "RP主机到期提醒 - {$rs->uname}将于". lpTools::niceTime($rs->expired) . "到期"; 
                $mailbody =  "RP主机到期提醒 - {$rs->uname}将于". lpTools::niceTime($rs->expired) . "到期"; 
                $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
                
                $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
                $smtp->debug = false;//是否显示发送的调试信息 
                $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "alertdelete":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                
                $smtpserver = $rpCfgMailHost;//SMTP服务器 
                $smtpserverport = 25;//SMTP服务器端口 
                $smtpusermail = $rpCfgMailEMail;//SMTP服务器的用户邮箱 
                $smtpemailto = $rs->email;//发送给谁 
                $smtpuser = $rpCfgMailUser;//SMTP服务器的用户帐号 
                $smtppass = $rpCfgMailPasswd;//SMTP服务器的用户密码 
                
                
                $mailsubject =  "RP主机删除提醒 - {$rs->uname}已于". lpTools::niceTime($rs->expired) . "到期"; 
                $mailbody =  "RP主机删除提醒 - {$rs->uname}已于". lpTools::niceTime($rs->expired) . "到期"; 
                $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
                
                $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
                $smtp->debug = false;//是否显示发送的调试信息 
                $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            default:
                echo "参数错误";
                return true;
        }
        
        return true;
    }
}

?>
