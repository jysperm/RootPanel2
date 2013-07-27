<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["panel-action.notLogin"] = "你还没有登录";
$rpL["panel-action.notAllowToPanel"] = "你还未开通付费帐号";
$rpL["panel-action.invalidIDOrPermission"] = "站点ID不存在或站点不属于你";
$rpL["panel-action.invalidCfgType"] = "未知的配置文件类型";
$rpL["panel-action.invalidPasswd"] = "密码不合法，可能含有特殊字符";

$rpL["panel-action.invalidDomain"] = "域名格式不正确";
$rpL["panel-action.alreadyBind"] = "以下域名已被其他人绑定，请联系客服：%s";
$rpL["panel-action.invalidSiteType"] = "站点类型不正确";
$rpL["panel-action.invalidAlias"] = "别名 %s 不正确";
$rpL["panel-action.invalidIndexs"] = "默认首页填写不正确";
$rpL["panel-action.invalidSSLCrt"] = "SSLCrt填写不正确";
$rpL["panel-action.invalidSSLKey"] = "SSLKey填写不正确";

return $rpL;