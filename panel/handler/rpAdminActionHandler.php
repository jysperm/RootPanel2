<?php

class rpAdminActionHandler extends lpHandler
{
    private function auth()
    {
        global $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!array_key_exists(rpAuth::uname(), $rpCfg["Admins"]))
            rpApp::goUrl("/panel/", true);
    }

    public function addTime()
    {
        $this->auth();

        $user = rpUserModel::find(["uname" => $_POST["uname"]]);
        $expired = (intval($user['expired']) + (intval($_POST["day"]) * 3600 * 24));
        rpUserModel::update(["uname" => $_POST["uname"]], ["expired" => $expired]);

        rpLogModel::log($_POST["uname"], "log.type.addTime", [intval($_POST["day"])], [], rpAuth::uname());

        echo json_encode(["status"=>"ok"]);
    }

    public function alertUser()
    {
        $this->auth();

        $title = "续费提醒 ";
        $title .= gmdate("Y.m.d");

        $content = "你的账户将于 " . gmdate("Y.m.d", rpUserModel::by("uname", $_POST["uname"])["expired"]) . "到期";

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        $cb = rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        $this->finishRequest();
        $cb();
    }

    public function getNewTicket()
    {
        $this->auth();
        global $rpROOT;

        lpTemplate::outputFile("{$rpROOT}/template/dialog/admin-new-ticket.php");
    }

    public function getPasswd()
    {
        $this->auth();
        global $lpCfg;

        $token = rpAuth::creatToken($_POST["uname"]);

        $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];
        $url = "/user/set-cookie/?{$cookieName["user"]}={$_POST["uname"]}&{$cookieName["passwd"]}={$token}";

        echo "<a href='{$url}''>{$url}</a>";
    }

    public function deleteUser()
    {
        $this->auth();

        rpUserModel::delete(["uname" => $_POST["uname"]]);

        rpLogModel::log($_POST["uname"], "log.type.delete", [], [], rpAuth::uname());

        echo json_encode(["status"=>"ok"]);
    }

    public function enableUser()
    {
        $this->auth();
        global $rpROOT, $rpL;

        rpUserModel::update(["uname" => $_POST['uname']],["type" => $_POST['type'], "expired" => time()]);

        $content = $title = "你的账户已经被开通为" . $rpL["global.userType"][$_POST['type']];

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        $cb = rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        $this->finishRequest();

        shell_exec("{$rpROOT}/../cli/create-account.php {$_POST['uname']}");
        $cb();
    }

    public function disableUser()
    {
        $this->auth();
        global $rpROOT;

        rpUserModel::update(["uname" => $_POST['uname']],["type" => rpUserModel::NO]);

        $content = $title = "你的账户已被停用";

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        $cb = rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        $this->finishRequest();

        shell_exec("{$rpROOT}/../cli/delete-account.php {$_POST['uname']} sure");
        $cb();
    }

    public function switchUser()
    {
        $this->auth();
        global $rpL;

        echo json_encode(["status"=>"ok"]);

        if(in_array($_POST['type'], array_keys($rpL["global.userType"])))
        {
            rpUserModel::update(["uname" => $_POST['uname']],["type" => $_POST['type']]);

            $content = $title = "你的账户已经被切换为" . $rpL["global.userType"][$_POST['type']];

            $data = [
                "users" => $_POST["uname"],
                "type" => "pay",
                "title" => $title,
                "content" => $content,
                "onlyclosebyadmin" => 0
            ];

            $cb = rpTicketModel::create($data);

            $this->finishRequest();

            $cb();
        }
    }
}