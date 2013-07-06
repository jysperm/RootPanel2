<?php

class rpPanelHandler extends lpHandler
{
    public function __invoke()
    {
        $this->auth();

        lpTemplate::outputFile(rpROOT . "/template/panel/index.php");
    }

    private function auth()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(f("lpUserModel")->isAdmin())
            rpApp::goUrl("/admin/", true);
    }

    public function logs()
    {
        $this->auth();

        lpTemplate::outputFile(rpROOT . "/template/panel/logs.php");
    }
}

