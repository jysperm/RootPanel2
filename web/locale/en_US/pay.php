<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["pay.buy"] = "Purchase";
$rpL["pay.positionList"] = "Node list";
$rpL["pay.agreement"] = "Terms of Service";

$rpL["pay.type.free"] = "Lite";
$rpL["pay.type.std"] = "Standard";
$rpL["pay.type.ext"] = "Pro";

$rpL["pay.price.free"] = "Free";
$rpL["pay.price.std"] = "8 CAD/Month, 19 CAD/Quarter";
$rpL["pay.price.ext"] = "15 CAD/Month, 35 CAD/Quarter";

$rpL["pay.signup"] = "Create a new Account";
$rpL["pay.apply"] = "Specifications";
$rpL["pay.goPay"] = "Payment";

$rpL["pay.info.noAccount"] = "If you do not have an account, please register before you purchase!";
$rpL["pay.info.alreadyBy"] = "You have purchased a RP Host. However you can still renew it:";

$rpL["pay.info.pay"] = <<< HTML
You can pay it through paypal directly and <b>leave your username <span style="color: red;">%s</span> in the comment field</b>. You can also choose different nodes to host your website from the following selections.
HTML;

$rpL["pay.info.notPay"] = <<< HTML
<p>You have not purchased a RP Host. Please choose a method to buy. If you have already pay the fee, please wait for the system to activating it. Or you can contact our customer service representative.</p>
<p>
Email：<code><i class="icon-envelope"></i>%s</code>
</p>
<ul class="left-tabs">
%s
</ul>
HTML;
$rpL["pay.info.notPay"] = sprintf($rpL["pay.info.notPay"], c("AdminsEmail"), l("contact.list"));


$rpL["pay.urls"] = [
    "std" => "http://item.taobao.com/item.htm?id=16169509767",
    "ext" => "http://item.taobao.com/item.htm?id=21047624871"
];

return $rpL;