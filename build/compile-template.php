#!/usr/bin/php
<?php

if(!isset($argc))
    die("Please run this file in shell.");

define("rpROOT", dirname(__FILE__) . "/..");

require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/core/include/App.php");
App::helloWorld();

$tools = [
    "jade" => "jade -P"
];

$baseOutputDir = rpROOT . "/compiled";

compileJadeDir(rpROOT . "/core/source/view", $baseOutputDir);

function compileJadeDir($dir, $outputDir)
{
    global $tools;

    print shell_exec("{$tools["jade"]} '{$dir}' --out '{$outputDir}/view'");

    foreach(new DirectoryIterator($dir) as $fileinfo)
    {
        /** @var DirectoryIterator $fileinfo */

        if($fileinfo->isDot() || $fileinfo->isDir() || substr($fileinfo->getFilename(),0, 1) == "_")
            continue;

        foreach(c("AvailableLanguage") as $language)
        {
            $source = "{$outputDir}/view/" . $fileinfo->getBasename(".jade") . ".html";
            $output = "{$outputDir}/template/" . $fileinfo->getBasename(".jade") . ".php";

            lpFactory::modify("lpLocale", new lpJSONLocale(rpCORE . "/locale", $language));

            lpCompiledTemplate::compile($source, $output);
        }
    }
}
