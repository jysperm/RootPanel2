#!/usr/bin/php
<?php

if(!isset($argc))
    die("Please run this file in shell.");

define("rpROOT", dirname(__FILE__) . "/..");

require_once(rpROOT . "/LightPHP/LightPHP.php");
require_once(rpROOT . "/core/include/rpApp.php");
App::helloWorld();

$tools = [
    "jade" => "nodejs /usr/lib/node_modules/jade/bin/jade -P"
];

$makeDirs = [
    "/compiled/plugin"
];

foreach($makeDirs as $dir)
    if(!file_exists(rpROOT . $dir))
        mkdir(rpROOT . $dir);

foreach(new DirectoryIterator(rpROOT . "/plugin") as $fileinfo)
{
    /** @var DirectoryIterator $fileinfo */
    if(!$fileinfo->isDot())
    {
        $pluginOut = rpROOT . "/compiled/plugin/{$fileinfo->getFilename()}";

        $makeDirs = [
            $pluginOut,
            "{$pluginOut}/template",
            "{$pluginOut}/view"
        ];

        foreach($makeDirs as $dir)
            if(!file_exists($dir))
                mkdir($dir);

        $jadeDir = "{$fileinfo->getPathname()}/source/view";
        if(file_exists($jadeDir) && count(scandir($jadeDir)) > 2)
            print shell_exec("{$tools["jade"]} {$jadeDir} --out {$pluginOut}/view");

        if(file_exists("{$pluginOut}/view"))
        {
            foreach(new DirectoryIterator("{$pluginOut}/view") as $f)
            {
                /** @var DirectoryIterator $f */
                lpCompiledTemplate::compile($f->getPathname(), "{$pluginOut}/template/" . $f->getBasename(".html") . ".php");
            }
        }
    }
}
