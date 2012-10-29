<?php

require_once("handler/global.php");

class Admin extends lpPage
{
    public function post()
    {
        global $lpCfgTimeToChina;
        
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
                        <td><?= $rsL->id;?></td><td><span title="<?= $rsL->ua;?>"><?= $rsL->ip;?></span></td><td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= $rsL->content;?></td>
                      </tr> 
                    <? endwhile; ?>
                  </tbody>
                </table>
                <?php
                return true;
            break;
            default:
                echo "参数错误";
                return true;
        }
    }
}

?>
