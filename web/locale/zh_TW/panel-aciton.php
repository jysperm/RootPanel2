<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["panel-action.notLogin"] = "妳還沒有登錄";
$rpL["panel-action.notAllowToPanel"] = "妳還未開通付費帳號";
$rpL["panel-action.invalidIDOrPermission"] = "站點ID不存在或站點不屬于妳";
$rpL["panel-action.invalidCfgType"] = "未知的配置文件類型";
$rpL["panel-action.invalidPasswd"] = "密碼不合法，可能含有特殊字符";

$rpL["panel-action.invalidDomain"] = "域名格式不正確";
$rpL["panel-action.alreadyBind"] = "以下域名已被其他人綁定，請聯系客服：%s";
$rpL["panel-action.invalidSiteType"] = "站點類型不正確";
$rpL["panel-action.invalidAlias"] = "別名 %s 不正確";
$rpL["panel-action.invalidIndexs"] = "默認首頁填寫不正確";
$rpL["panel-action.invalidSSLCrt"] = "SSLCrt填寫不正確";
$rpL["panel-action.invalidSSLKey"] = "SSLKey填寫不正確";

return $rpL;