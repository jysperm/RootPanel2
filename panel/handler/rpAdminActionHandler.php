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
        global $rpCfg;
        $this->auth();

        $user = rpUserModel::find(["uname" => $_POST["uname"]]);
    }

    public function getNewTicket()
    {
        global $rpROOT;

        lpTemplate::outputFile("{$rpROOT}/template/dialog/admin-new-ticket.php");
    }

    public function getPasswd()
    {
        global $lpCfg;
        $db = lpFactory::get("PDO");

        $token = rpAuth::creatToken($_POST["uname"]);

        $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];
        $url = "/user/set-cookie/?{$cookieName["user"]}={$_POST["uname"]}&{$cookieName["passwd"]}={$token}";

        echo "<a href='{$url}''>{$url}</a>";
    }
}