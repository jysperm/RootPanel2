<?php

class rpPanelHandler extends lpHandler
{
    public function __invoke()
    {
        lpLocale::i()->load(["global", "panel", "log"]);
        global $rpROOT;

        $this->auth();

        lpTemplate::outputFile("{$rpROOT}/template/panel/index.php");
    }

    private function auth()
    {
        global $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(array_key_exists(rpAuth::uname(), $rpCfg["Admins"]))
            rpApp::goUrl("/admin/", true);
    }

    public function logs($page = null)
    {
        global $rpROOT;
        lpLocale::i()->load(["global", "logs", "log"]);

        $this->auth();

        $page = intval($page);

        $tmp = new lpTemplate("{$rpROOT}/template/panel/logs.php");
        $tmp->page = $page ? : 1;
        $tmp->output();
    }
}

class VirtualHost extends lpAction
{
    public function get()
    {
        global $rpROOT;

        if(!isset($_POST["id"]))
            lpRoute::quit("参数不全");

        $uname = lpAuth::getUName();
        $rs = $this->conn->select("virtualhost", array("id" => $_POST["id"]));
        if($rs->read() && $rs->uname == $uname) {
            $tmp = new lpTemplate("{$rpROOT}/template/edit-website.php");
            $tmp->rs = $rs->rawArray();
            $tmp->output();
        } else {
            lpRoute::quit("站点ID不存在或站点不属于你");
        }
    }

    public function delete()
    {
        global $rpROOT;

        if(!isset($_POST["id"]))
            lpRoute::quit("参数不全");

        $rs = $this->conn->select("virtualhost", array("id" => $_POST["id"]));
        if($rs->read() && $rs->uname == lpAuth::getUName()) {
            $cfgOld = json_encode($rs->rawArray());
            makeLog(lpAuth::getUName(), "删除了站点{$rs->id}，配置为{$cfgOld}");

            $this->conn->delete("virtualhost", array("id" => $_POST["id"]));
            shell_exec("{$rpROOT}/../cli-tools/web-conf-maker.php {$rs->uname}");

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError("站点ID不存在或站点不属于你");
        }
    }

    public function edit()
    {
        global $lpCfgTimeToChina, $rpROOT;

        if(!isset($_POST["id"]))
            lpRoute::quit("参数不全");

        $rs = $this->conn->select("virtualhost", array("id" => $_POST["id"]));
        if($rs->read() && $rs->uname == lpAuth::getUName()) {
            if($this->checkInput()) {
                $row = $this->row;
                $row["lastchange"] = time() + $lpCfgTimeToChina;
                $cfgOld = json_encode($rs->rawArray());
                $cfgNew = json_encode($row);

                makeLog(lpAuth::getUName(), "修改了站点{$rs->id}，原配置为：{$cfgOld},新配置为{$cfgNew}");

                $this->conn->update("virtualhost", array("id" => $_POST["id"]), $row);
                shell_exec("{$rpROOT}/../cli-tools/web-conf-maker.php " . lpAuth::getUName());

                echo json_encode(array("status" => "ok"));
            } else {
                jsonError($this->msg);
            }
        } else {
            jsonError("站点ID不存在或站点不属于你");
        }
    }

    public function add()
    {
        global $lpCfgTimeToChina, $rpROOT;

        if($this->checkInput(true)) {
            $row = $this->row;
            $row["time"] = time() + $lpCfgTimeToChina;
            $row["ison"] = 1;
            $row["uname"] = lpAuth::getUName();
            $row["lastchange"] = time() + $lpCfgTimeToChina;
            $cfgNew = json_encode($row);

            makeLog(lpAuth::getUName(), "创建了站点{$this->conn->insertId()}，配置为：{$cfgNew}");

            $this->conn->insert("virtualhost", $row);
            shell_exec("{$rpROOT}/../cli-tools/web-conf-maker.php " . lpAuth::getUName());

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError($this->msg);
        }
    }

    public function sshpasswd()
    {
        if(!isset($_POST["passwd"]))
            lpRoute::quit("参数不全");

        if(preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $uname = lpAuth::getUName();
            shell_exec("echo '{$uname}:{$_POST['passwd']}' | sudo chpasswd");

            makeLog($uname, "修改了SSH密码");

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError("密码不合法");
        }
    }

    public function pptppasswd()
    {
        global $rpROOT;

        if(!isset($_POST["passwd"]))
            lpRoute::quit("参数不全");

        if(preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $uname = lpAuth::getUName();

            $this->conn->update("user", array("uname" => $uname), array("pptppasswd" => $_POST["passwd"]));

            shell_exec("sudo {$rpROOT}/../cli-tools/pptp-passwd.php");

            makeLog($uname, "修改了PPTP密码");

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError("密码不合法");
        }
    }

    public function mysqlpasswd()
    {
        if(!isset($_POST["passwd"]))
            lpRoute::quit("参数不全");

        if(preg_match('/^[A-Za-z0-9\-_]+$/', $_POST["passwd"])) {
            $uname = lpAuth::getUName();

            $this->conn->exec("SET PASSWORD FOR '%s'@'localhost' = PASSWORD('%s');", $uname, $_POST["passwd"]);

            makeLog(lpAuth::getUName(), "修改了MySQL密码");

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError("密码不合法");
        }
    }

    public function panelPasswd()
    {
        if(isset($_POST["passwd"])) {
            $uname = lpAuth::getUName();

            $this->conn->update("user", array("uname" => $uname), array("passwd" => lpAuth::DBHash($uname, $_POST["passwd"])));

            makeLog(lpAuth::getUName(), "修改了面板密码");

            echo json_encode(array("status" => "ok"));
        } else {
            jsonError("密码不合法");
        }
    }
}
