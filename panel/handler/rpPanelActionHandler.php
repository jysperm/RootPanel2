<?php

class rpPanelActionHandler extends lpHandler
{
    private function auth()
    {
        global $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!rpUser::isAllowToPanel(rpAuth::uname()))
            if(array_key_exists(rpAuth::uname(), $rpCfg["Admins"]))
                rpApp::goUrl("/admin/", true);
            else
                rpApp::goUrl("/pay/", true);
    }

    public function getNewVHost()
    {
        global $rpROOT;

        $tmp = new lpTemplate("{$rpROOT}/template/edit-website.php");
        $tmp->new = true;
        $tmp->output();
    }
}