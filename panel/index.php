<?php

define("lpMode", "debug");
require_once("LightPHP/lp-load.php");
require_once("config.php");

$lpApp = lpApp::helloWorld();

$lpApp->registerDatabase(new lpMySQLDBDrive($rpCfg["MySQLDB"]));
$lpApp->registerAuthTool(new lpTrackAuth);

$lpApp->registerAutoload(function($name)
{
    global $rpROOT;
    $path = "{$rpROOT}/handler/{$name}.php";
    if(file_exists($path))
        require_once($path);
},[
    "lppublic" => "lpPublic"
]);

$lpApp->registerDefaultPath([
    "template" => "{$rpROOT}/template"
]);

$lpApp::$defaultHandlerName = "rpIndex";
$lpApp::$handlerPerfix = "rp";

rpUser::initCallBack();

$lpApp->bindLambda(null, $lpApp::$defaultFilter);







