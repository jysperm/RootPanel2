<?php

class rpTicketHandler extends lpHandler
{
    public function __invoke()
    {
        rpApp::goUrl("/ticket/list/");
    }

    public function __call($name, $args)
    {
        if(in_array($name, ["list"]))
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

    public function create()
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $ticket = [
            "time" => time(),
            "uname" => rpAuth::uname(),
            "title" => $_POST["title"],
            "onlyclosebyadmin" => 0,
            "type" => $_POST["type"],
            "status" => "ticket.status.open",
            "lastchange" => time(),
            "replys" => 0,
            "lastreply" => rpAuth::uname(),
            "content" => $_POST["content"]
        ];

        rpApp::q("Ticket")->insert($ticket);

        echo json_encode(["status" => "ok"]);
    }

    public function reply($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = rpApp::q("Ticket")->where(["id" => $id])->top();
        if($tk["uname"] != rpAuth::uname())
            die("该工单不属于你");
        if(!$tk)
            die("工单ID无效");

        $reply = [
            "replyto" => $id,
            "time" => time(),
            "uname" => rpAuth::uname(),
            "content" => $_POST["content"]
        ];

        rpApp::q("TicketReply")->insert($reply);

        echo json_encode(["status" => "ok"]);
    }

    public function view($id = null)
    {
        global $rpROOT;
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = rpApp::q("Ticket")->where(["id" => $id])->top();
        if($tk["uname"] != rpAuth::uname())
            die("该工单不属于你");
        if(!$tk)
            die("工单ID无效");

        $tmp = new lpTemplate("{$rpROOT}/template/ticket/view.php");
        $tmp->tk = $tk;
        $tmp->output();
    }
}