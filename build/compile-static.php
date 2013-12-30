#!/usr/bin/php
<?php

if (!isset($argc))
    die("Please run this file in shell.");

define("rpROOT", dirname(__FILE__) . "/..");
$rpROOT = rpROOT;

$baseOutputDir = rpROOT . "/static";

print shell_exec("{$tools["cp"]} '{$rpROOT}/Core/source/image' '{$baseOutputDir}/image'");
