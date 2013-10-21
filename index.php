<?php

define("rpROOT", dirname(__FILE__));

require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/core/include/App.php");

App::helloWorld([
    "RunLevel" => lpDebug
]);

App::bind('^/user/(signup|login|logout)/?', function($act) {
    UserHandler::invoke($act);
});

App::exec();

