<?php

class rpIndexHandler extends lpHandler
{
    public function __invoke()
    {
        lpLocale::i()->load(["contant"]);
        lpTemplate::outputFile(lpLocale::i()->file("template/index.php"));
    }
}
