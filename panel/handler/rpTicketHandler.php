<?php

class rpTicketHandler extends lpHandler
{
    public function __invoke()
    {
        rpApp::goUrl("/ticket/list/");
    }

    public function __call($name, $args)
    {
        if(in_array($name, ["list", "new"]))
            call_user_func_array([$this, "rp{$name}"], $args);
    }

    public function rpList($page = null)
    {
        lpLocale::i()->load(["ticket"]);
        global $rpROOT;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $page = intval($page);
        $tmp = new lpTemplate("{$rpROOT}/template/ticket/index.php");
        $tmp->page = $page ? : 1;
        $tmp->output();
    }

    public function rpNew()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $settings = [
            "title" => $_POST["title"],
            "onlyclosebyadmin" => false,
            "type" => $_POST["type"],
            "status" => "ticket.status.open",
            "lastchange" => time(),
            "lastreply" => rpAuth::uname()
        ];

        $ticket = [
            "replyto" => 0,
            "time" => time(),
            "uname" => rpAuth::uname(),
            "settings" => json_encode($settings),
            "content" => $_POST["content"]
        ];

        rpApp::q("Ticket")->insert($ticket);

        echo json_encode(["status" => "ok"]);
    }
}