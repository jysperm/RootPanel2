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

    public function rpList()
    {
        lpLocale::i()->load(["ticket"]);
        global $rpROOT;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        lpTemplate::outputFile("{$rpROOT}/template/ticket/index.php");
    }

    public function create()
    {
        lpLocale::i()->load(["ticket"]);
        global $rpL, $rpCfg;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!in_array($_POST["type"], array_keys($rpL["ticket.types"])))
            die("类型不合法");

        $ticket = [
            "time" => time(),
            "uname" => rpAuth::uname(),
            "title" => rpTools::escapePlantText($_POST["title"]),
            "onlyclosebyadmin" => 0,
            "type" => $_POST["type"],
            "status" => "ticket.status.open",
            "lastchange" => time(),
            "replys" => 0,
            "lastreply" => rpAuth::uname(),
            "content" => rpTools::escapePlantText($_POST["content"])
        ];

        $id = rpTicketModel::insert($ticket);
        rpLogModel::log(rpAuth::uname(), "log.type.createTicket", [$id, $id], $ticket);

        $mailer = lpFactory::get("lpSmtp");
        $mailTitle = "NewTK | {$rpCfg["NodeID"]} | " . rpAuth::uname() . " | {$ticket["title"]}";
        $mailBody = "{$ticket["content"]}<br />";
        $mailBody .= "<a href='http://{$rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"]}/ticket/view/{$id}/'># {$id}</a>";

        $mailer->send($rpCfg["adminsEmail"], $mailTitle, $mailBody, lpSmtp::HTMLMail);

        echo json_encode(["status" => "ok"]);
    }

    public function reply($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            die("工单ID无效");
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            die("该工单不属于你");

        $tk->reply($_POST);

        echo json_encode(["status" => "ok"]);
    }

    public function view($id = null)
    {
        global $rpROOT;
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            die("工单ID无效");
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            die("该工单不属于你");

        $tmp = new lpTemplate("{$rpROOT}/template/ticket/view.php");
        $tmp['tk'] = $tk;
        $tmp->output();
    }

    public function close($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        global $rpCfg;

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            die("工单ID无效");
        if($tk["uname"] != rpAuth::uname())
            die("该工单不属于你");
        if($tk["status"] == "ticket.status.closed")
            die("该工单已经被关闭");
        if($tk["onlyclosebyadmin"])
            die("该工单只能被管理员关闭");

        rpTicketModel::update(["id" => $id], ["status" => "ticket.status.closed"]);
        rpLogModel::log(rpAuth::uname(), "log.type.closeTicket", [$id, $id], []);

        $mailer = lpFactory::get("lpSmtp");
        $mailTitle = "TKClose | {$rpCfg["NodeID"]} | " . rpAuth::uname() . " | {$tk["title"]}";
        $mailBody = "<a href='http://{$rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"]}/ticket/view/{$tk["id"]}/'># {$tk["id"]}</a>";

        $mailer->send($rpCfg["adminsEmail"], $mailTitle, $mailBody, lpSmtp::HTMLMail);

        echo json_encode(["status" => "ok"]);
    }
}