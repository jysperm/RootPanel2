<?php

namespace RootPanel;

use RootPanel\Core\Core\Application;

require_once("LightPHP/LightPHP.php");
require_once("Core/Core/Application.php");

Application::helloWorld([
    "RunLevel" => lpDebug
]);
