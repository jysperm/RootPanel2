<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        /** @var lpLocale $rpL */
        $rpL = f("lpLocale");
        lpTemplate::outputFile($rpL->file("template/index.php"));
    }
}
