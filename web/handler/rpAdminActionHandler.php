<?php

class rpAdminActionHandler extends lpHandler
{
    private function jsonError($msg)
    {
        return json_encode(["success" => false, "msg" => $msg]);
    }

    private function auth()
    {
        if(!rpAuth::login())
            return $this->jsonError(l("admin-action.notLogin"));

        if(!lpFactory::get("rpUserModel")->isAdmin())
            return $this->jsonError(l("admin-action.notAdmin"));
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
        f("lpLocale")->load(["base", "admin-action"]);

        $expiredTime = gmdate(l("base.data"), rpUserModel::by("uname", $_POST["uname"])["expired"]);
        $title = l("admin-action.ticket.alert.title", $expiredTime);
        $content = l("admin-action.ticket.alert.content", $expiredTime);

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        rpApp::finishRequest();
    }

    public function getNewTicket()
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/dialog/admin-new-ticket.php");
    }

    public function getEditSettings($uname = null)
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/dialog/admin-edit-settings.php", ["uname" => $uname]);
    }

    public function editSettings($uname = null)
    {
        $this->auth();
        rpUserModel::update(["uname" => $uname], ["settings" => [
            "pptppasswd" => $_POST["pptppasswd"], "nginxextconfig" => $_POST["nginxextconfig"], "apache2extconfig" => $_POST["apache2extconfig"]]
        ]);

        rpApp::reloadWebConfig($uname);
    }

    public function getPasswd()
    {
        $this->auth();

        $token = rpAuth::creatToken($_POST["uname"]);

        $cookieUser = rpAuth::USER;
        $cookiePasswd = rpAuth::PASSWD;
        $url = "/user/set-cookie/?{$cookieUser}={$_POST["uname"]}&{$cookiePasswd}={$token}";

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
        f("lpLocale")->load(["base", "admin-action"]);

        rpUserModel::update(["uname" => $_POST['uname']],["type" => $_POST['type'], "expired" => time()]);

        $title = l("admin-action.ticket.enable.title", l("base.userType")[$_POST['type']]);
        $content = l("admin-action.ticket.enable.content", l("base.userType")[$_POST['type']]);

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        rpApp::finishRequest();

        shell_exec(rpROOT . "/../cli/create-account.php {$_POST['uname']}");
    }

    public function disableUser()
    {
        $this->auth();
        f("lpLocale")->load(["base", "admin-action"]);

        rpUserModel::update(["uname" => $_POST['uname']],["type" => rpUserModel::NO]);

        $title = l("admin-action.ticket.enable.title");
        $content = l("admin-action.ticket.enable.content");

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);

        rpApp::finishRequest();

        shell_exec(rpROOT . "/../cli/delete-account.php {$_POST['uname']} sure");
    }

    public function switchUser()
    {
        $this->auth();
        f("lpLocale")->load(["base", "admin-action"]);

        if(in_array($_POST['type'], array_keys(l("base.userType"))))
        {
            rpUserModel::update(["uname" => $_POST['uname']],["type" => $_POST['type']]);
        }

        echo json_encode(["status"=>"ok"]);
    }
}