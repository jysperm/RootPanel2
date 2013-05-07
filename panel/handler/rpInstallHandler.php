<?php

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
    }
}