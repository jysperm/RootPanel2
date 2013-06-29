<?php

global $rpL, $rpCfg;

$rpL["login.tips.noInput"] = "请输入账号和密码";
$rpL["login.tips.passwdError"] = "用户名或密码错误";

$rpL["login.view.isForgetPasswd"] = "忘记密码？";
$rpL["login.view.isDontHaveAccount"] = "还没有帐号？";
$rpL["login.view.clickToSignup"] = "点击这里注册";
$rpL["login.view.forgetPasswd.email"] = "通过邮件找回";
$rpL["login.view.forgetPasswd.qq"] = "通过QQ找回";


$adminEMail = array_values($rpCfg["Admins"])[0]["email"];
$rpL["login.popover.resetPasswdEMail"] = <<< HTML

请用你的注册邮箱，向客服邮箱<code><i class="icon-envelope"></i>{$adminEMail}</code>发送邮件.

HTML;

$rpL["login.popover.resetPasswdQQ"] = <<< HTML

使用你设置的QQ, 联系客服 {$rpL["contact.qqButton"]}.

HTML;
