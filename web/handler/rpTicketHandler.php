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
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        lpTemplate::outputFile(rpROOT . "/template/ticket/index.php");
    }

    public function create()
    {
        /** @var lpLocale $rpL */
        $rpL = f("lpLocale");
        $rpL->load("ticket");

        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        if(!in_array($_POST["type"], array_keys(l("ticket.types"))))
            throw new Exception(l("ticket.handler.invalidType"));

        rpTicketModel::create($_POST);

        echo json_encode(["status" => "ok"]);

        rpApp::finishRequest();
    }

    public function reply($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            throw new Exception(l("ticket.handler.invalidID"));
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.invalidPermission"));

        $tk->reply($_POST);
        echo json_encode(["status" => "ok"]);

        rpApp::finishRequest();
    }

    public function view($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            throw new Exception(l("ticket.handler.invalidID"));
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.invalidPermission"));

        lpTemplate::outputFile(rpROOT . "/template/ticket/view.php", ["tk" => $tk]);
    }

    public function close($id = null)
    {
        if(!rpAuth::login())
            rpApp::goUrl("/user/login/", true);

        $isAdmin = lpFactory::get("rpUserModel")->isAdmin();

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            throw new Exception(l("ticket.handler.invalidID"));
        if($tk["uname"] != rpAuth::uname() && !$isAdmin)
            throw new Exception(l("ticket.handler.invalidPermission"));
        if($tk["status"] == rpTicketModel::CLOSED)
            throw new Exception(l("ticket.handler.alreadyClosed"));
        if($tk["onlyclosebyadmin"] && !$isAdmin)
            throw new Exception(l("ticket.handler.closeOnlyByAdmin"));

        $tk->close();
        echo json_encode(["status" => "ok"]);

        rpApp::finishRequest();
    }

    public function finish($id = null)
    {
        if(!lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.notAdmin"));

        $tk = new rpTicketModel($id);

        $tk->finish();
        echo json_encode(["status" => "ok"]);

        rpApp::finishRequest();
    }
}