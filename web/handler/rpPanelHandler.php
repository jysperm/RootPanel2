<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpPanelHandler extends lpHandler
{
    private function auth()
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

        if(f("rpUserModel")->isAdmin())
            App::goUrl("/admin/", true);
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

