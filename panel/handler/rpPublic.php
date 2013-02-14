<?php

class rpPublic extends lpHandler
{
    public function review()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/review.php");
    }

    public function manual()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/manual.php");
    }
}