<?php

namespace RootPanel\Core\Core;

use LightPHP\Core\Handler;
use LightPHP\View\PHPTemplate;

class PageHandler extends Handler
{
    protected function render($template, $values = [])
    {
        return PHPTemplate::outputFile(rpCORE . "/template/{$template}", $values);
    }
}
