<?php

class rpPublicHandler extends lpHandler
{
    public function __call($name, $args)
    {
        if(in_array($name, ["review", "sites", "pay"]))
            lpTemplate::outputFile(rpROOT . "/template/public/{$name}.php");
    }
}