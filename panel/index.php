<?php

define("lpMode", "debug");
require_once("LightPHP/lp-load.php");
require_once("config.php");
require_once("$rpROOT/template/messages.php");
require_once("{$rpROOT}/handler/rpApp.php");

rpApp::helloWorld();

rpApp::bindLambda(null, new lpDefaultFilter("rpIndex", "rpH"));
