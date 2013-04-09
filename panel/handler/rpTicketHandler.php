<?php

class rpTicketHandler extends lpHandler
{
    public function __invoke()
    {
        rpApp::goUrl("/ticket/list/");
    }

    public function __call($name, $args)
    {
        if($name == "list")
            call_user_func_array([$this, "rpList"], $args);
    }

    public function rpList($page = null)
    {
        global $rpROOT;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $page = intval($page);
        $tmp = new lpTemplate("{$rpROOT}/template/ticket/index.php");
        $tmp->page = $page ? : 1;
        $tmp->output();
    }
}