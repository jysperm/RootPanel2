<?php

class rpPayHandler extends lpHandler
{
    public function __invoke()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/pay/pay.php");
    }

    public function free()
    {
        rpApp::goUrl("/ticket/list/?template=freeRequest");
    }
}