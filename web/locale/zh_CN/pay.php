<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["pay.buy"] = "购买";
$rpL["pay.positionList"] = "机房列表";
$rpL["pay.agreement"] = "政策和约定";

$rpL["pay.type.free"] = "试用版";
$rpL["pay.type.std"] = "标准版";
$rpL["pay.type.ext"] = "额外技术支持版";

$rpL["pay.price.free"] = "免费";
$rpL["pay.price.std"] = "每月8元，每季度19元";
$rpL["pay.price.ext"] = "每月15元，每季度35元";

$rpL["pay.signup"] = "注册帐号";
$rpL["pay.apply"] = "填写申请";
$rpL["pay.goPay"] = "去淘宝付款";

$rpL["pay.info.noAccount"] = "如果你还没在本站注册过帐号，请先注册帐号再购买！";
$rpL["pay.info.alreadyBy"] = "你已经购买过RP主机了，不过你还可以续费：";

$rpL["pay.info.pay"] = <<< HTML
您直接在淘宝拍下对应商品即可，并记得<b>在备注中填写您的用户名 <span style="color: red;">%s</span></b>，你还可以在下方的机房列表中选择你想要的机房.
HTML;

$rpL["pay.info.notPay"] = <<< HTML
<p>你还没有购买RP主机，请在下方选择一种方式购买，如果你已经在淘宝付款成功，请耐心等待开通，或通过下面方式联系客服。</p>
<p>
邮箱：<code><i class="icon-envelope"></i>%s</code>
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