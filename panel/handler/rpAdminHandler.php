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

    public function ticket($uname = null)
    {
        $this->auth();

        lpLocale::i()->load(["ticket"]);
        global $rpROOT;

        lpTemplate::outputFile("{$rpROOT}/template/admin/ticket-list.php", ["uname" => $uname]);
    }

    public function logs($uname = null)
    {
        global $rpROOT;
        lpLocale::i()->load(["global", "logs", "log"]);

        $this->auth();

        lpTemplate::outputFile("{$rpROOT}/template/panel/logs.php", ["uname" => $uname]);
    }
}