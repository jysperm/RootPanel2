<?php

class rpPanelAction extends lpHandler
{
    private function auth()
    {
        global  $rpCfg, $lpApp;

        if(!$lpApp->auth()->login())
            $lpApp->goUrl("/user/login/", true);

        if(!rpUser::isAllowToPanel($lpApp->auth()->getUName()))
            if(array_key_exists($lpApp->auth()->getUName(), $rpCfg["Admins"]))
                $lpApp->goUrl("/admin/", true);
            else
                $lpApp->goUrl("/pay/", true);
    }

    public function getNewVHost()
    {
        global $rpROOT;

        $tmp = new lpTemplate("{$rpROOT}/template/edit-website.php");
        $tmp->new = true;
        $tmp->output();
    }
}