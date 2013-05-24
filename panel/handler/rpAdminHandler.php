<?php

class rpAdminHandler extends lpHandler
{
    private function auth()
    {
        global $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!array_key_exists(rpAuth::uname(), $rpCfg["Admins"]))
            rpApp::goUrl("/panel/", true);
    }

    public function __invoke()
    {
        global $rpROOT;

        $this->auth();

        lpTemplate::outputFile("{$rpROOT}/template/admin/index.php");
    }

    public function ticket()
    {
        $this->auth();

        lpLocale::i()->load(["ticket"]);
        global $rpROOT;

        lpTemplate::outputFile("{$rpROOT}/template/admin/ticket-list.php");
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


}