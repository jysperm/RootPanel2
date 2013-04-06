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

        $tmp = new lpTemplate("{$rpROOT}/template/dialog/edit-website.php");
        $tmp->setValue("new", true);
        $tmp->output();
    }

    public function getExtConfig($type)
    {
        $this->auth();

        if(!in_array($type, ["apache2", "nginx"]))
            die("参数错误");

        $user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();
        $config = json_decode($user["settings"], true)["{$type}extconfig"];

        echo "<pre>{$config}</pre>";
    }
}