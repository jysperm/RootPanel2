<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["login.account"] = "帳號";
$rpL["login.passwd"] = "密碼";

$rpL["login.view.isForgetPasswd"] = "忘記密碼？";
$rpL["login.view.isDontHaveAccount"] = "還沒有帳號？";
$rpL["login.view.clickToSignup"] = "點擊這裏注冊";
$rpL["login.view.forgetPasswd.email"] = "通過郵件找回";
$rpL["login.view.forgetPasswd.qq"] = "通過QQ找回";

$rpL["login.tips.noInput"] = "請輸入賬號和密碼";
$rpL["login.tips.passwdError"] = "用戶名或密碼錯誤";

$rpL["login.popover.resetPasswdEMail"] = <<< HTML
請用妳的注冊郵箱，向客服郵箱<code><i class="icon-envelope"></i>%s</code>發送郵件.
HTML;

$rpL["login.popover.resetPasswdQQ"] = <<< HTML
使用妳設置的QQ, 聯系客服 %s.
HTML;

return $rpL;