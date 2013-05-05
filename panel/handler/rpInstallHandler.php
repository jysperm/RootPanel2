<?php

class rpInstallHandler extends lpHandler
{
    public function __invoke()
    {
        rpUserModel::install();
        rpLogModel::install();
        lpTrackAuthModel::install();
    }
}