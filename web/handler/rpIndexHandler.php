<?php

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        /** @var lpLocale $rpL */
        $rpL = f("lpLocale");
        lpTemplate::outputFile($rpL->file("template/index.php"));
    }
}
