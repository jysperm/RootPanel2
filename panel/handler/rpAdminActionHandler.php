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

        $title = $_POST["type"] == "renew" ? "续费提醒 " : "删除提醒 ";
        $title .= gmdate("Y.m.d");

        $content = "你的账户将于 " . gmdate("Y.m.d", rpUserModel::by("uname", $_POST["uname"])["expired"]) . "到期";

        $data = [
            "users" => $_POST["uname"],
            "type" => "pay",
            "title" => $title,
            "content" => $content,
            "onlyclosebyadmin" => 0
        ];

        rpTicketModel::create($data);

        echo json_encode(["status"=>"ok"]);
    }

    public function getNewTicket()
    {
        global $rpROOT;

        lpTemplate::outputFile("{$rpROOT}/template/dialog/admin-new-ticket.php");
    }

    public function getPasswd()
    {
        global $lpCfg;

        $token = rpAuth::creatToken($_POST["uname"]);

        $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];
        $url = "/user/set-cookie/?{$cookieName["user"]}={$_POST["uname"]}&{$cookieName["passwd"]}={$token}";

        echo "<a href='{$url}''>{$url}</a>";
    }
}