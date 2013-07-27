<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        lpTemplate::outputFile(f("lpLocale")->file("template/index.php"));
    }
}
