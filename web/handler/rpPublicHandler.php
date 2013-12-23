<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpPublicHandler extends lpHandler
{
    public function __call($name, $args)
    {
        if (in_array($name, ["review", "sites", "pay"]))
            lpTemplate::outputFile(rpROOT . "/template/public/{$name}.php");
    }
}