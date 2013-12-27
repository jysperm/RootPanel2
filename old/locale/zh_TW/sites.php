<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["sites.title"] = "優質站點展示";

$rpL["sites.big"] = [
    [
        "img" => "http://i.imgur.com/hDioltj.png",
        "domain" => "jyprince.me",
        "url" => "http://jyprince.me/",
        "name" => "精英王子的博客",
        "description" => "該博客包含了精英王子的生活點滴和壹些技術教程"
    ], [
        "img" => "http://i.imgur.com/pYyZM85.png",
        "domain" => "im.librazy.org",
        "url" => "http://im.librazy.org/",
        "name" => "Librazy的博客",
        "description" => "Librazy是壹個高中OI黨"
    ], [
        "img" => "http://i.imgur.com/k554meP.jpg",
        "domain" => "www.smxybbs.net",
        "url" => "http://www.smxybbs.net/",
        "name" => "三明學院論壇",
        "description" => "福建省三明學院官方論壇，壹個以學習，動漫爲話題的綜合SNS社區"
    ]
];

$rpL["sites.small"] = [
    [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "等待入住",
        "description" => "所有RP主機用戶均可申請"
    ], [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "等待入住",
        "description" => "所有RP主機用戶均可申請"
    ], [
        "img" => c("StaticPrefix") . "/style/300x200.png",
        "domain" => "",
        "url" => "",
        "name" => "等待入住",
        "description" => "所有RP主機用戶均可申請"
    ]
];

return $rpL;