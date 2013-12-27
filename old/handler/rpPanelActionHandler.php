<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpPanelActionHandler extends lpJSONHandler
{
    public function __construct()
    {
        f("lpLocale")->load("panel-action");

        parent::__construct();
    }

    private function jsonError($msg)
    {
        return json_encode(["success" => false, "message" => $msg]);
    }

    private function auth()
    {
        if (!rpAuth::login())
            return $this->jsonError(l("panel-action.notLogin"));

        if (!lpFactory::get("rpUserModel")->isAllowToPanel())
            return $this->jsonError(l("panel-action.notAllowToPanel"));
    }

    public function getNewVHost()
    {
        $this->auth();

        lpTemplate::outputFile(rpROOT . "/template/dialog/edit-website.php", ["new" => true]);
    }

    public function getVHost()
    {
        $this->auth();

        $vhost = new rpVirtualHostModel($_POST["id"]);
        if ($vhost->isNull() || $vhost["uname"] != rpAuth::uname())
            die(l("panel-action.invalidIDOrPermission"));

        lpTemplate::outputFile(rpROOT . "/template/dialog/edit-website.php", ["vhost" => $vhost]);
    }

    public function createVHost()
    {
        $this->auth();
        $data = $this->checkInput();

        if ($data["ok"]) {
            $data = $data["data"];

            $general = [
                "alias" => $data["alias"],
                "autoindex" => $data["autoindex"],
                "indexs" => $data["indexs"],
                "isssl" => $data["isssl"],
                "sslcrt" => $data["sslcrt"],
                "sslkey" => $data["sslkey"]
            ];

            $vhost = [
                "uname" => rpAuth::uname(),
                "domains" => $data["domains"],
                "lastchange" => time(),
                "general" => $general,
                "source" => $data["source"],
                "type" => $data["type"],
                "settings" => $data["settings"],
                "ison" => $data["ison"]
            ];

            $id = rpVirtualHostModel::insert($vhost);
            rpLogModel::log(rpAuth::uname(), "log.type.createVHost", [$id, $id], $vhost);

            echo json_encode(["success" => "ok"]);
            App::reloadWebConfig(rpAuth::uname());
        } else {
            $this->jsonError($data["msg"]);
        }
    }

    public function editVHost($id = null)
    {
        $this->auth();

        $vhost = new rpVirtualHostModel($id);
        if ($vhost->isNull() || $vhost["uname"] != rpAuth::uname())
            die(l("panel-action.invalidIDOrPermission"));

        $data = $this->checkInput($id);
        if ($data["ok"]) {
            $data = $data["data"];

            $general = [
                "alias" => $data["alias"],
                "autoindex" => $data["autoindex"],
                "indexs" => $data["indexs"],
                "isssl" => $data["isssl"],
                "sslcrt" => $data["sslcrt"],
                "sslkey" => $data["sslkey"]
            ];

            $vhost = [
                "uname" => rpAuth::uname(),
                "domains" => $data["domains"],
                "lastchange" => time(),
                "general" => $general,
                "source" => $data["source"],
                "type" => $data["type"],
                "settings" => $data["settings"],
                "ison" => $data["ison"]
            ];

            rpVirtualHostModel::update(["id" => $id], $vhost);
            rpLogModel::log(rpAuth::uname(), "log.type.editVHost", [$id, $id], $vhost);

            echo json_encode(["success" => "ok"]);

            App::reloadWebConfig(rpAuth::uname());
        } else {
            $this->jsonError($data["msg"]);
        }
    }

    public function deleteVHost()
    {
        $this->auth();

        $vhost = new rpVirtualHostModel($_POST["id"]);
        if ($vhost->isNull() || $vhost["uname"] != rpAuth::uname())
            die(l("panel-action.invalidIDOrPermission"));

        rpVirtualHostModel::delete(["id" => $_POST["id"]]);
        rpLogModel::log(rpAuth::uname(), "log.type.deleteVHost", [$_POST["id"]], []);

        echo json_encode(["success" => "ok"]);
    }

    public function getExtConfig($type)
    {
        $this->auth();

        if (!in_array($type, ["apache2", "nginx"]))
            die(l("panel-action.invalidCfgType"));

        $config = lpFactory::get("rpUserModel")["settings"]["{$type}extconfig"];

        echo "<pre>{$config}</pre>";
    }

    public function sshPasswd()
    {
        $this->auth();
        if (preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $uname = rpAuth::uname();
            shell_exec("echo '{$uname}:{$_POST['passwd']}' | sudo chpasswd");

            rpLogModel::log($uname, "log.type.sshPasswd", [], []);

            echo json_encode(["success" => true]);
        } else {
            $this->jsonError(l("panel-action.invalidPasswd"));
        }
    }

    public function pptppasswd()
    {
        $this->auth();

        if (preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $uname = rpAuth::uname();

            $lock = new lpMutex;

            $settings = rpUserModel::find(["uname" => $uname])["settings"];
            $settings["pptppasswd"] = $_POST["passwd"];
            rpUserModel::update(["uname" => $uname], ["settings" => $settings]);

            $lock = null;

            rpLogModel::log($uname, "log.type.pptpPasswd", [], []);

            echo json_encode(["success" => true]);

            App::finishRequest();
            shell_exec("sudo " . rpROOT . "/../cli/pptp-passwd.php");
        } else {
            $this->jsonError(l("panel-action.invalidPasswd"));
        }
    }

    public function mysqlpasswd()
    {
        $this->auth();
        if (preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $db = lpFactory::get("PDO");
            $uname = rpAuth::uname();

            $db->exec(sprintf("SET PASSWORD FOR '%s'@'localhost' = PASSWORD('%s');", $uname, $_POST["passwd"]));

            rpLogModel::log($uname, "log.type.mysqlPasswd", [], []);

            echo json_encode(["success" => true]);
        } else {
            $this->jsonError(l("panel-action.invalidPasswd"));
        }
    }

    public function panelPasswd()
    {
        $this->auth();
        if (isset($_POST["passwd"])) {
            $uname = rpAuth::uname();
            rpUserModel::update(["uname" => $uname], ["passwd" => rpAuth::dbHash($uname, $_POST["passwd"])]);

            rpLogModel::log($uname, "log.type.panelPasswd", [], []);

            echo json_encode(array("success" => true));
        } else {
            $this->jsonError(l("panel-action.invalidPasswd"));
        }
    }

    /**
     * @param int $id
     *
     * @return array ["ok" => true|false, "msg" => <错误信息>, "data" => "成功过滤后的数据"]
     */
    private function checkInput($id = null)
    {
        $types = rpVHostType::loadTypes();
        $data = [];

        // 开关
        $data["ison"] = $_POST["ison"] ? 1 : 0;
        $data["autoindex"] = $_POST["autoindex"] ? 1 : 0;
        $data["isssl"] = $_POST["isssl"] ? 1 : 0;


        // domains-域名
        // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
        // ^ *DOMAIN( DOMAIN)* *$
        if (!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',
                $_POST["domains"]) || strlen($_POST["domains"]) > 128
        ) {
            return ["ok" => false, "msg" => l("panel-action.invalidDomain")];
        } else {
            $data["domains"] = strtolower(trim(str_replace("  ", " ", $_POST["domains"])));

            if (!$id) {
                $rsDomains = rpVirtualHostModel::select();
            } else {
                $db = lpFactory::get("PDO");
                $rsDomains = $db->query("SELECT * FROM `virtualhost` WHERE `id` <> " . $db->quote($id));
            }

            foreach ($rsDomains as $row) {
                $tD = explode(" ", $row["domains"]);
                $curD = explode(" ", $data["domains"]);

                $errDomains = array_intersect($tD, $curD);
                if (count($errDomains))
                    return ["ok" => false, "msg" => l("panel-action.alreadyBind", join(" ", $errDomains))];
            }
        }

        // type站点类型
        if (!in_array($_POST["type"], array_keys($types)))
            return ["ok" => false, l("panel-action.invalidSiteType")];
        $data["type"] = $_POST["type"];

        // 类型相关选项
        $perfix = "vhost-{$data["type"]}-";
        $settings = [];
        foreach ($_POST as $k => $v)
            if (substr($k, 0, strlen($perfix)) == $perfix)
                $settings[substr($k, strlen($perfix))] = $v;

        $r = $types[$_POST["type"]]->checkSettings($settings, $_POST["source"]);
        if (!$r["ok"])
            return ["ok" => false, "msg" => $r["msg"]];

        $data["settings"] = $r["data"];
        $data["source"] = $_POST["source"];


        // alias别名
        $aliasR = [];
        $alias = explode("\n", $_POST["alias"]);
        foreach ($alias as $v) {
            $vv = explode(" ", trim(str_replace("  ", " ", $v)));

            if (isset($vv[0]) && isset($vv[1]) && $vv[0] && $vv[1]) {
                if (!preg_match('/^\S+$/', $vv[0]) || strlen($vv[0]) > 128)
                    return ["ok" => false, l("panel-action.invalidAlias", $vv[0])];

                if (!lpFactory::get("rpUserModel")->checkFileName($vv[1]))
                    return ["ok" => false, l("panel-action.invalidAlias", $vv[1])];

                $aliasR[$vv[0]] = $vv[1];
            }
        }
        $data["alias"] = $aliasR;

        // indexs默认首页
        // [A-Za-z0-9_\-\.]+
        // ^ *FILENAME( FILENAME)* *$
        // ^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$
        if (!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/', $_POST["indexs"]) ||
            strlen($_POST["indexs"]) > 256
        ) {
            return ["ok" => false, l("panel-action.invalidIndexs")];
        }
        $data["indexs"] = $_POST["indexs"];

        // SSL
        if ($data["isssl"]) {
            if (!lpFactory::get("rpUserModel")->checkFileName($_POST["sslcrt"]) || !file_exists($_POST["sslcrt"]))
                return ["ok" => false, l("panel-action.invalidSSLCrt")];

            if (!lpFactory::get("rpUserModel")->checkFileName($_POST["sslkey"]) || !file_exists($_POST["sslkey"]))
                return ["ok" => false, l("panel-action.invalidSSLKey")];

            $data["sslcrt"] = $_POST["sslcrt"];
            $data["sslkey"] = $_POST["sslkey"];
        } else {
            $data["sslcrt"] = $data["sslkey"] = "";
        }

        return ["ok" => true, "data" => $data];
    }
}