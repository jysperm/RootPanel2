<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["pay.buy"] = "購買";
$rpL["pay.positionList"] = "機房列表";
$rpL["pay.agreement"] = "政策和約定";

$rpL["pay.type.free"] = "試用版";
$rpL["pay.type.std"] = "標准版";
$rpL["pay.type.ext"] = "額外技術支持版";

$rpL["pay.price.free"] = "免費";
$rpL["pay.price.std"] = "每月8元，每季度19元";
$rpL["pay.price.ext"] = "每月15元，每季度35元";

$rpL["pay.signup"] = "注冊帳號";
$rpL["pay.apply"] = "填寫申請";
$rpL["pay.goPay"] = "去淘寶付款";

$rpL["pay.info.noAccount"] = "如果妳還沒在本站注冊過帳號，請先注冊帳號再購買！";
$rpL["pay.info.alreadyBy"] = "妳已經購買過RP主機了，不過妳還可以續費：";

$rpL["pay.info.pay"] = <<< HTML
您直接在淘寶拍下對應商品即可，並記得<b>在備注中填寫您的用戶名 <span style="color: red;">%s</span></b>，妳還可以在下方的機房列表中選擇妳想要的機房.
HTML;

$rpL["pay.info.notPay"] = <<< HTML
<p>妳還沒有購買RP主機，請在下方選擇壹種方式購買，如果妳已經在淘寶付款成功，請耐心等待開通，或通過下面方式聯系客服。</p>
<p>
郵箱：<code><i class="icon-envelope"></i>%s</code>
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