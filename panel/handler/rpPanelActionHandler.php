<?php

class rpPanelActionHandler extends lpHandler
{
    private function jsonError($msg)
    {
        echo json_encode(["statuc" => "error", "msg" => $msg]);
    }

    private function auth()
    {
        if(!rpAuth::login())
            $this->jsError("未登录");

        if(!rpUserModel::me()->isAllowToPanel())
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
        return print_r($_POST, false);

        $data = $this->checkInput();
        if($data["ok"])
        {
            $vhost = [
                "uname" => rpAuth::uname(),
                "domains" => $data["domains"],
                "lastchange" => $data["lastchange"],
                "general" => ["alias" => $data["alias"], "autoindex" => $data["autoindex"], "indexs" => $data["indexs"]],
                "source" => $data["source"],
                "type" => $data["type"],
                "settings" => [],
                "ison" => true
            ];


        }
        else
        {
            $this->jsonError($data["msg"]);
        }
    }

    public function getExtConfig($type)
    {
        $this->auth();

        if(!in_array($type, ["apache2", "nginx"]))
            die("参数错误");

        $config = rpUserModel::me()["settings"]["{$type}extconfig"];

        echo "<pre>{$config}</pre>";
    }

    /**
     * @param bool $isNew
     *
     * @return array ["ok" => true|false, "msg" => <错误信息>, "data" => "成功过滤后的数据"]
     */
    private function checkInput($isNew = false)
    {
        $data = [];

        // domains-域名
        // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
        // ^ *DOMAIN( DOMAIN)* *$
        if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',
            $_POST["domains"]) || strlen($_POST["domains"]) > 128 )
        {
            return ["ok" => false, "msg" => "域名格式不正确"];
        }
        else
        {
            $data["domains"] = strtolower(trim(str_replace("  ", " ", $_POST["domains"])));

            if($isNew)
            {
                $rsDomains = rpVirtualHostModel::select();
            }
            else
            {
                $db = rpApp::getDB();
                $rsDomains = $db->query("SELECT * FROM `virtualhost` WHERE `id` <> " . $db->quote($_POST["id"]));
            }

            foreach($rsDomains as $row)
            {
                $tD = explode(" ", $row["domains"]);
                $curD = explode(" ", $data["domains"]);

                $errDomains = array_intersect($tD, $curD);
                if(count($errDomains))
                    return ["ok" => false, "以下域名已被其他人绑定，请联系客服：" . join(" ", $errDomains)];
            }
        }
    }
}