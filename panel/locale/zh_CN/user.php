<?php

global $rpL;

/* ----- 注册 ----- */

$rpL["signup.tips.incomplete"] = "请将信息填写完整";
$rpL["signup.tips.notAllowSignup"] = "该用户名不允许注册";
$rpL["signup.tips.userExists"] = "该用户名已存在";

$rpL["signup.rule"] = <<< HTML

<ul>
  <li>帐号仅可以使用英文、数字、下划线,且第一个字符必须为英文字母</li>
  <li>邮箱务必为正确的邮箱地址</li>
</ul>

HTML;

$rpL["signup.tmp.signup"] = "注册";
$rpL["signup.tmp.isHasAccount"] = "已有帐号？";
$rpL["signup.tmp.clickToLogin"] = "点击这里登录";
$rpL["signup.tmp.service"] = "咨询";

$rpL["signup.tmp.signingNow"] = "你正在注册的是：";

$rpL["signup.tmp.account"] = "帐号";
$rpL["signup.tmp.accountTips"] = "你可以使用英文、数字、下划线作为帐号,第一个字符必须为英文字母";
$rpL["signup.tmp.emailTips"] = "邮箱是与你联系的重要途径，请务必使用正确的邮箱，并经常检查邮件";
$rpL["signup.tmp.passwd"] = "密码";
$rpL["signup.tmp.isRaw"] = "明文";
$rpL["signup.tmp.qq"] = "QQ";
$rpL["signup.tmp.qqTips"] = "RP主机的QQ客服将会依据该项辨别你的身份，可以留空";

/* ----- 登录 ----- */

$rpL["login.tips.noInput"] = "请输入账号和密码";
$rpL["login.tips.passwdError"] = "用户名或密码错误";