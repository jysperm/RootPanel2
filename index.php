<?php

namespace RootPanel;

use LightPHP\Core\Router;
use RootPanel\Core\Core\Application;

require_once("LightPHP/LightPHP.php");
require_once("Core/Core/Application.php");

Application::helloWorld([
    "RunLevel" => lpDebug
]);

Application::registerRouters();
Router::exec();
