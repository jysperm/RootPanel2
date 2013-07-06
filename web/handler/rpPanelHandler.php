<?php

class rpPanelHandler extends lpHandler
{
    private function auth()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(f("rpUserModel")->isAdmin())
            rpApp::goUrl("/admin/", true);
    }

    public function __invoke()
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/panel/index.php");
    }

    public function logs()
    {
        $this->auth();
        lpTemplate::outputFile(rpROOT . "/template/panel/logs.php");
    }
}

