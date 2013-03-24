<?php

class rpPanelActionHandler extends lpHandler
{
    private function auth()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!rpUser::isAllowToPanel(rpAuth::uname()))
            if(rpUser::isAdmin(rpAuth::uname()))
                rpApp::goUrl("/admin/", true);
            else
                rpApp::goUrl("/pay/", true);
    }

    public function getNewVHost()
    {
        global $rpROOT;

        $tmp = new lpTemplate("{$rpROOT}/template/edit-website.php");
        $tmp->setValue("new", true);
        $tmp->output();
    }
}