<?php

class LoginAs extends lpAction
{
    public function loginas()
    {
        if(!isset($_GET["uname"]) || !isset($_GET["passwd"]))
        {
            lpMVC::exit("参数不全");
        }
        else
        {
            lpAuth::login($_GET["uname"],$_GET["passwd"],false,false,true);
            $this->gotoUrl("/panel/");
        }
    }
}

class AdminPage extends lpPage
{
    public function get()
    {
        global $rpAdminUsers;
    
        if(!lpAuth::login() || !in_array(lpAuth::getUName(),$rpAdminUsers))
        {
            gotoUrl("/login/");
            exit();
        }
            
        lpTemplate::parseFile("template/admin.php");
    }
}

class Admin extends lpPage
{
    
    
    public function post()
    {
        global $lpCfgTimeToChina,$rpCfgMailUser,$rpCfgMailPasswd,$rpCfgMailEMail,$rpCfgMailHost,$lpROOT,$rpAdminUsers;
        
        if(!lpAuth::login() || !in_array(lpAuth::getUName(),$rpAdminUsers))
        {
            echo "未登录或不是管理员";
            return true;
        }
        
        $conn=new lpMySQL;
        
        switch($_POST["do"])
        {
            case "addtime":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                $conn->update("user",array("uname"=>$_POST["uname"]),array("expired"=> (intval($rs->expired) + (intval($_POST["day"])*3600*24))));
                makeLog($_POST["uname"],"被增加了{$_POST["day"]}天的使用时长");
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
                    makeLog($_POST["uname"],"被删除");
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
            case "alertpay":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();

                $mailer=new lpSmtpMail();

                $mailTitle="RP主机到期提醒 - {$rs->uname}将于". lpTools::niceTime($rs->expired) . "到期";
                $mailBody=$mailTitle;
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
                
                makeLog($_POST["uname"],$mailBody);
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "alertdelete":
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();

                $mailer=new lpSmtpMail();

                $mailTitle="RP主机删除提醒 - {$rs->uname}已于". lpTools::niceTime($rs->expired) . "到期";
                $mailBody=$mailTitle;
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
              
                makeLog($_POST["uname"],$mailbody);
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "tostd":
                shell_exec("{$lpROOT}/../core/creat-account.php {$_POST['uname']}");
                
                $conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"std"));
                
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();

                $mailer=new lpSmtpMail();

                $mailTitle="RP主机开通提醒 "; 
                $mailBody="RP主机开通提醒(标准付费版)"; 
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
                
                makeLog($_POST["uname"],"被开通为标准付费用户");
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "toext":
                shell_exec("{$lpROOT}/../core/creat-account.php {$_POST['uname']}");
                
                $conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"ext"));
                
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                
                $mailer=new lpSmtpMail();

                $mailTitle="RP主机开通提醒 "; 
                $mailBody="RP主机开通提醒(额外技术支持版)"; 
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
                
                makeLog($_POST["uname"],"被开通为额外技术支持用户");
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "tofree":
                shell_exec("{$lpROOT}/../core/creat-account.php {$_POST['uname']}");
                
                $conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"free"));
                
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                
                $mailer=new lpSmtpMail();

                $mailTitle="RP主机开通提醒 "; 
                $mailBody="RP主机开通提醒(免费试用)"; 
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
                
                makeLog($_POST["uname"],"被开通为免费试用用户");
                
                $r["status"]="ok";
                echo json_encode($r);
                return true;
            break;
            case "tono":
                shell_exec("{$lpROOT}/../core/delete-account.php {$_POST['uname']} sure");
                
                $conn->update("user",array("uname"=>$_POST["uname"]),array("type"=>"no"));
                
                $rs=$conn->select("user",array("uname"=>$_POST["uname"]));
                $rs->read();
                
                $mailer=new lpSmtpMail();

                $mailTitle="RP主机开删除提醒 "; 
                $mailBody=$mailTitle;
                
                $mailer->send($rs->email,$mailTitle,$mailBody,"HTML");
                
                makeLog($_POST["uname"],"被删除用户");
                
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
