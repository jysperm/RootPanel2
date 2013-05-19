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
}