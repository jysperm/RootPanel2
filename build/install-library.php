#!/usr/bin/php
<?php

if(!isset($argc))
    die("Please run this file in shell.");

define("rpROOT", dirname(__FILE__) . "/..");

require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/core/include/App.php");
App::helloWorld();

$tools = [
    "wget" => "wget"
];

$baseOutputDir = rpROOT . "/static/library";
