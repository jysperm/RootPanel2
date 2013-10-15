<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpInstallHandler extends lpHandler
{
    public function __invoke()
    {
        lpTrackAuthModel::install();
        rpUserModel::install();
        rpLogModel::install();
        rpVirtualHostModel::install();
        rpTicketModel::install();
        rpTicketReplyModel::install();

        App::goUrl("/");
    }

    public function license()
    {
        echo json_encode(c("License"));
    }
}