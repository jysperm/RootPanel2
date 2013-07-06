<?php

class rpAdminHandler extends lpHandler
{
    private function auth()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!f("lpUserModel")->isAdmin())
            rpApp::goUrl("/panel/", true);
    }

    public function __invoke()
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/admin/index.php");
    }

    public function ticket($uname = null)
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/admin/ticket-list.php", ["uname" => $uname]);
    }

    public function logs($uname = null)
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/panel/logs.php", ["uname" => $uname]);
    }
}