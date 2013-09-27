<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["login.account"] = "Account";
$rpL["login.passwd"] = "Password";

$rpL["login.view.isForgetPasswd"] = "Forgot your password?";
$rpL["login.view.isDontHaveAccount"] = "Do not have an account?";
$rpL["login.view.clickToSignup"] = "Clike to register";
$rpL["login.view.forgetPasswd.email"] = "retrive by email";
$rpL["login.view.forgetPasswd.qq"] = "retrive by QQ";

$rpL["login.tips.noInput"] = "Please enter your Account and Password";
$rpL["login.tips.passwdError"] = "The account and the password do not match.";

$rpL["login.popover.resetPasswdEMail"] = <<< HTML
Please send an email to the customer service <code><i class="icon-envelope"></i>%s</code> through your documented email address.
HTML;

$rpL["login.popover.resetPasswdQQ"] = <<< HTML
Please contact the customer service %s through your documented QQ.
HTML;

return $rpL;