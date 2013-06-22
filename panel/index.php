<?php

define("rpROOT", dirname(__FILE__));

require_once("{$rpROOT}/LightPHP/lp-load.php");
require_once("{$rpROOT}/include/rpApp.php");

rpApp::helloWorld();

rpApp::bind(null, lpDefaultRouter(["Index"], "rp"));
