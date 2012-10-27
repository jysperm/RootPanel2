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
          
            default:
                echo "参数错误";
                return true;
        }
    }
}

?>
