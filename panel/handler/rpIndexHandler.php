<?php

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        global $rpROOT, $rpCfg;
        lpTemplate::outputFile("{$rpROOT}/locale/{$rpCfg['lang']}/template/index.php");
    }
}
