<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpTicketHandler extends lpHandler
{
    public function __construct()
    {
        f("lpLocale")->load("ticket");

        parent::__construct();
    }

    public function __invoke()
    {
        App::goUrl("/ticket/list/");
    }

    public function rpList()
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

        lpTemplate::outputFile(rpROOT . "/template/ticket/index.php");
    }

    public function view($id = null)
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            throw new Exception(l("ticket.handler.invalidID"));
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.invalidPermission"));

        lpTemplate::outputFile(rpROOT . "/template/ticket/view.php", ["tk" => $tk]);
    }

    // 以下是 JSON 请求，之所以没有使用单独的处理器，是因为需要 rpApp::finishRequest().

    public function create()
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

        if(!in_array($_POST["type"], array_keys(l("ticket.types"))))
            throw new Exception(l("ticket.handler.invalidType"));

        rpTicketModel::create($_POST);

        echo json_encode(["status" => "ok"]);

        App::finishRequest();
    }

    public function reply($id = null)
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

        $tk = new rpTicketModel($id);
        if($tk->isNull())
            throw new Exception(l("ticket.handler.invalidID"));
        if($tk["uname"] != rpAuth::uname() && !lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.invalidPermission"));

        $tk->reply($_POST);
        echo json_encode(["status" => "ok"]);

        App::finishRequest();
    }

    public function close($id = null)
    {
        if(!rpAuth::login())
            App::goUrl("/user/login/", true);

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

        App::finishRequest();
    }

    public function finish($id = null)
    {
        if(!lpFactory::get("rpUserModel")->isAdmin())
            throw new Exception(l("ticket.handler.notAdmin"));

        $tk = new rpTicketModel($id);

        $tk->finish();
        echo json_encode(["status" => "ok"]);

        App::finishRequest();
    }
}