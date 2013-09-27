<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["signup.account"] = "帳號";
$rpL["signup.passwd"] = "密碼";
$rpL["signup.email"] = "郵箱";

$rpL["signup.tips.incomplete"] = "請將信息填寫完整";
$rpL["signup.tips.notAllowSignup"] = "該用戶名不允許注冊";
$rpL["signup.tips.userExists"] = "該用戶名已存在";

$rpL["signup.rule"] = <<< HTML

<ul>
  <li>帳號僅可以使用英文、數字、下劃線,且第壹個字符必須爲英文字母</li>
  <li>郵箱務必爲正確的郵箱地址</li>
</ul>

HTML;

$rpL["signup.view.isHasAccount"] = "已有帳號？";
$rpL["signup.view.clickToLogin"] = "點擊這裏登錄";

$rpL["signup.view.signingNow"] = "妳正在注冊的是：";

$rpL["signup.view.accountTips"] = "妳可以使用英文、數字、下劃線作爲帳號,第壹個字符必須爲英文字母";
$rpL["signup.view.emailTips"] = "郵箱是與妳聯系的重要途徑，請務必使用正確的郵箱，並經常檢查郵件";
$rpL["signup.view.isRaw"] = "明文";
$rpL["signup.view.qq"] = "QQ";
$rpL["signup.view.qqTips"] = "RP主機的QQ客服將會依據該項辨別妳的身份，可以留空";

return $rpL;