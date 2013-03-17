<?php

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        lpTemplate::outputFile(lpLocale::i()->file("template/index.php"));
    }
}
