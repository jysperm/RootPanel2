<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["sites.title"] = "Showcase";

$rpL["sites.big"] = [
    [
        "img" => "http://i.imgur.com/hDioltj.png",
        "domain" => "jyprince.me",
        "url" => "http://jyprince.me/",
        "name" => "精英王子的博客",
        "description" => "该博客包含了精英王子的生活点滴和一些技术教程"
    ], [
        "img" => "http://i.imgur.com/pYyZM85.png",
        "domain" => "im.librazy.org",
        "url" => "http://im.librazy.org/",
        "name" => "Librazy的博客",
        "description" => "Librazy是一个高中OI党"
    ], [
        "img" => "http://i.imgur.com/k554meP.jpg",
        "domain" => "www.smxybbs.net",
        "url" => "http://www.smxybbs.net/",
        "name" => "三明学院论坛",
        "description" => "福建省三明学院官方论坛，一个以学习，动漫为话题的综合SNS社区"
    ]
];

$rpL["sites.small"] = [
    [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "Empty Slot",
        "description" => "Any RP Host user can apply"
    ], [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "Empty Slot",
        "description" => "Any RP Host user can apply"
    ], [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "Empty Slot",
        "description" => "Any RP Host user can apply"
    ]
];

return $rpL;