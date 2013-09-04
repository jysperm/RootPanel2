<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["signup.account"] = "Account";
$rpL["signup.passwd"] = "Password";
$rpL["signup.email"] = "Email";

$rpL["signup.tips.incomplete"] = "Please fill up the required fields";
$rpL["signup.tips.notAllowSignup"] = "The account name is reserved";
$rpL["signup.tips.userExists"] = "The account name has been already registered";

$rpL["signup.rule"] = <<< HTML

<ul>
  <li>Your username should be started with an alphabetical letter and can only include lowercase letters, under scores and numbers.</li>
  <li>Your email address must be valid.</li>
</ul>

HTML;

$rpL["signup.view.isHasAccount"] = "Already registered?";
$rpL["signup.view.clickToLogin"] = "Click here to login";

$rpL["signup.view.signingNow"] = "你正在注册的是：";

$rpL["signup.view.accountTips"] = "Your username should be started with an alphabetical letter and can only include lowercase letters, under scores and numbers.";
$rpL["signup.view.emailTips"] = "Email is important to keep you connected with important notifications. Please enter a valid email address and check your inbox frequently.";
$rpL["signup.view.isRaw"] = "Show Characters";
$rpL["signup.view.qq"] = "QQ";
$rpL["signup.view.qqTips"] = "RP Host's Customer Service Representative could validate your identity through this field. It is optional.";

return $rpL;