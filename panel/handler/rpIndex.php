<?php

class rpIndex extends lpHandler
{
    public function __invoke()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/index.php");
    }
}
