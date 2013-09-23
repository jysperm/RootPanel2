<?php

define("rpROOT", dirname(__FILE__));
define("rpCORE", rpROOT . "/core");

require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/core/include/rpApp.php");

rpApp::helloWorld(["RunLevel" => lpDebug]);

lpPlugin::registerPluginDir(rpROOT . "/plugin");
lpPlugin::initPlugin();


lpPlugin::bindRoute();
rpApp::exec();

