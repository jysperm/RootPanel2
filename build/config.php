<?php

namespace RootPanel\CLI;

if (!isset($argc))
    die("Please run this file in shell.");

$rpROOT = dirname(__FILE__) . "/..";

$config = include("{$rpROOT}/Core/config/library.php");

$baseOutputDir = rpROOT . "/static";

$tools = [
    "cp" => "cp -r"
];
