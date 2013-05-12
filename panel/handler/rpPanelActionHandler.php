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
        $types = rpVHostType::loadTypes();
        $data = [];

        // 开关
        $data["ison"] = $_POST["ison"] ?: 1;
        $data["autoindex"] = $_POST["autoindex"] ?: 1;
        $data["isssl"] = $_POST["isssl"] ?: 0;


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

        // template模板类型
        if(!in_array($_POST["type"], array_keys($types))) {
            $this->msg = "type参数错误";
            return ["ok" => false, "type参数错误"];
        }
        $data["type"] = $_POST["type"];

        // alias别名
        $aliasR = [];
        $alias = explode("\n", $_POST["alias"]);
        foreach($alias as $v) {
            $vv = explode(" ", trim(str_replace("  ", " ", $v)));

            if(isset($vv[0]) && isset($vv[1]) && $vv[0] && $vv[1])
            {
                if(!preg_match('/^\S+$/', $vv[0]) || strlen($vv[0]) > 128)
                    return ["ok" => false, "别名{$vv[0]}不正确"];

                if(!rpUserModel::me()->checkFileName($vv[1]))
                    return ["ok" => false, "别名{$vv[1]}不正确"];

                $aliasR[$vv[0]] = $vv[1];
            }
        }
        $row["alias"] = $aliasR;

        // indexs默认首页
        // [A-Za-z0-9_\-\.]+
        // ^ *DOMAIN( DOMAIN)* *$
        // ^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$
        if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/', $_POST["indexs"]) ||
            strlen($_POST["indexs"]) > 256
        ) {
            return ["ok" => false, "indexs格式不正确"];
        }
        $data["indexs"] = $_POST["indexs"];

        // SSL
        if($data["isssl"])
        {
            if(!rpUserModel::me()->checkFileName($_POST["sslcrt"]) || !file_exists($_POST["sslcrt"]))
                return ["ok" => false, "sslcrt不正确或不存在"];

            if(!rpUserModel::me()->checkFileName($_POST["sslkey"]) || !file_exists($_POST["sslkey"]))
                return ["ok" => false, "sslkey不正确或不存在"];

            $data["sslcrt"] = $_POST["sslcrt"];
            $data["sslkey"] = $_POST["sslkey"];
        }
    }
}