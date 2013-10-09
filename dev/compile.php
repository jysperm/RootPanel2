#!/usr/bin/php
<?php

if(!isset($argc))
    die("Please run this file in shell.");

$rpROOT = dirname(__FILE__) . "/..";

$tools = [
    "jade" => "nodejs /usr/lib/node_modules/jade/bin/jade -P"
];

$makeDirs = [
    "/compiled/view"
];

foreach($makeDirs as $dir)
    if(!file_exists("{$rpROOT}{$dir}"))
        mkdir("{$rpROOT}{$dir}");

foreach(new DirectoryIterator("{$rpROOT}/plugin") as $fileinfo)
{
    /** @var DirectoryIterator $fileinfo */
    if(!$fileinfo->isDot())
    {
        $jadeDir = "{$fileinfo->getPathname()}/source/view";
        if(file_exists($jadeDir) && count(scandir($jadeDir)) > 2)
            print shell_exec("{$tools["jade"]} {$jadeDir} --out {$rpROOT}/compiled/view");
    }
}
