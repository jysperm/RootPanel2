<?php

namespace RootPanel;

use LightPHP\Core\Router;
use RootPanel\Core\Core\Application;

require_once("LightPHP/LightPHP.php");
require_once("Core/Core/Application.php");

print 1;

Application::helloWorld([
    "RunLevel" => lpDebug
]);

print 1;

Application::registerRouters();

print 1;

Router::exec(function() {
    header("HTTP/1.1 404 Not Found");
    header("Content-Type: text/html");

    print "404 Not Found";
});
