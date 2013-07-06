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

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        lpTemplate::outputFile(rpROOT . "/template/ticket/index.php");
    }

    public function create()
    {
        lpLocale::i()->load(["ticket"]);
        global $rpL;

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!in_array($_POST["type"], array_keys($rpL["ticket.types"])))
            die("类型不合法");

        $cb = rpTicketModel::create($_POST);

        echo json_encode(["status" => "ok"]);

        $this->finishRequest();

        $cb();
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

        $cb = $tk->reply($_POST);
        echo json_encode(["status" => "ok"]);

        $this->finishRequest();
        $cb();
    }

    public function view($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            die("工单ID无效");
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            die("该工单不属于你");

        $tmp = new lpTemplate(rpROOT . "/template/ticket/view.php");
        $tmp['tk'] = $tk;
        $tmp->output();
    }

    public function close($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $isAdmin = lpFactory::get("rpUserModel")->isAdmin();

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            die("工单ID无效");
        if($tk["uname"] != rpAuth::uname() && !$isAdmin)
            die("该工单不属于你");
        if($tk["status"] == rpTicketModel::CLOSED)
            die("该工单已经被关闭");
        if($tk["onlyclosebyadmin"] && !$isAdmin)
            die("该工单只能被管理员关闭");

        $cb = $tk->close();
        echo json_encode(["status" => "ok"]);

        $this->finishRequest();
        $cb();
    }

    public function finish($id = null)
    {
        if(!lpFactory::get("rpUserModel")->isAdmin())
            die("非管理员");

        $tk = new rpTicketModel($id);

        $cb = $tk->finish();
        echo json_encode(["status" => "ok"]);

        $this->finishRequest();
        $cb();
    }
}