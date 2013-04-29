<?php

class rpPanelActionHandler extends lpHandler
{
    private $data, $msg;

    private function jsError($msg)
    {
        echo json_encode(["msg" => $msg]);
    }

    private function auth()
    {
        if(!rpAuth::login())
            $this->jsError("未登录");

        if(!rpUser::isAllowToPanel(rpAuth::uname()))
            $this->jsError("未开通");
    }

    public function getNewVHost()
    {
        global $rpROOT;

        $tmp = new lpTemplate("{$rpROOT}/template/dialog/edit-website.php");
        $tmp->setValue("new", true);
        $tmp->output();
    }

    public function add()
    {

    }

    public function getExtConfig($type)
    {
        $this->auth();

        if(!in_array($type, ["apache2", "nginx"]))
            die("参数错误");

        $user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();
        $config = json_decode($user["settings"], true)["{$type}extconfig"];

        echo "<pre>{$config}</pre>";
    }

    private function checkInput($isNew = false)
    {
        // domains-域名
        // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
        // ^ *DOMAIN( DOMAIN)* *$
        if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',
            $_POST["domains"]) || strlen($_POST["domains"]) > 128
        ) {
            $this->msg = "域名格式不正确";
            return false;
        } else {
            $row["domains"] = strtolower(trim(str_replace("  ", " ", $_POST["domains"])));
            if($isNew) {
                $rsD = rpApp::q("virtualhost")->select();
            } else {
                $id = rpApp::getDB()->drive()
            }
            $rsD = rpApp::getDB()->drive()->command("SELECT * FROM `virtualhost` WHERE `id` <> '%i'")
                $rsD = $this->conn->exec("SELECT * FROM `virtualhost` WHERE `id` <> '%i'", $_POST["id"]);
            while($rsD->read()) {
                $tD = explode(" ", $rsD->domains);
                $curD = explode(" ", $row["domains"]);
                if(count(array_intersect($tD, $curD))) {
                    $this->msg = "以下域名已被其他人绑定，请联系客服：" . join(" ", array_intersect($tD, $curD));
                    return false;
                }
            }
        }
    }
}