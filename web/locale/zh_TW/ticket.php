<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["ticket.title"] = "工單列表";
$rpL["ticket.ticketList"] = "工單列表 #%s";
$rpL["ticket.create"] = "創建工單";

$rpL["ticket.list.id"] = "ID";
$rpL["ticket.list.type"] = "類型";
$rpL["ticket.list.status"] = "狀態";
$rpL["ticket.list.title"] = "標題";
$rpL["ticket.list.reply"] = "回複";

$rpL["ticket.nav.opeator"] = "操作";
$rpL["ticket.nav.returnList"] = "返回列表";
$rpL["ticket.nav.returnPanel"] = "返回面板";

$rpL["ticket.opeator.close"] = "關閉工單";
$rpL["ticket.opeator.finish"] = "標記完成";
$rpL["ticket.opeator.content"] = "回複內容";
$rpL["ticket.opeator.reply"] = "創建回複";
$rpL["ticket.opeator.closed"] = "工單已被關閉";

$rpL["ticket.replyBy"] = "%s 個回複 | %s 于 %s";

$rpL["ticket.create.content"] = "內容";
$rpL["ticket.create.create"] = "創建工單";

$rpL["ticket.types"] = [
    "pay" => "財務問題",
    "panel" => "面板使用",
    "miao" => "調戲客服",
    "web" => "Web環境",
    "linux" => "Linux環境",
    "runtime" => "語言支持"
];
$rpL["ticket.types.default"] = "miao";

$rpL["ticket.types.long"] = [
    "pay" => "購買/續費/支付",
    "panel" => "面板使用/Bug彙報",
    "miao" => "調戲客服",
    "web" => "Web環境(Nginx/Apache2)",
    "linux" => "Linux環境",
    "runtime" => "語言支持(PHP/Python等)"
];

$rpL["ticket.status.open"] = "開放中";
$rpL["ticket.status.hode"] = "客服已回複";
$rpL["ticket.status.finish"] = "客服已處理";
$rpL["ticket.status.closed"] = "已關閉";

$rpL["ticket.handler.invalidType"] = "工單類型錯誤";
$rpL["ticket.handler.invalidID"] = "無效工單ID";
$rpL["ticket.handler.invalidPermission"] = "妳對該工單沒有權限";
$rpL["ticket.handler.alreadyClosed"] = "該工單已經關閉";
$rpL["ticket.handler.closeOnlyByAdmin"] = "該工單只能被管理員關閉";
$rpL["ticket.handler.notAdmin"] = "只有管理員可以標記完成";

$rpL["ticket.createMail.title"] = "TK Create | %s | %s | %s";
$rpL["ticket.createMail.body"] = <<< HTML
%s<br /><a href='http://%s/ticket/view/%s/'># %s | %s</a>
HTML;


$rpL["ticket.template"]["freeRequest"]["title"] = "試用申請";
$rpL["ticket.template"]["freeRequest"]["type"] = "pay";
$rpL["ticket.template"]["freeRequest"]["content"] = <<< HTML
## 請先填寫下列問卷(100-300字爲宜)
* 年齡, 職業
* 從何處得知RP主機
* 是否會編程，如果會的話掌握哪些技術
* 妳將會用RP主機幹什麽
* 爲什麽選擇了試用而不是直接購買

HTML;

$rpL["ticket.template"]["configRequest"]["title"] = "配置文件審核申請";
$rpL["ticket.template"]["configRequest"]["type"] = "web";
$rpL["ticket.template"]["configRequest"]["content"] = <<< HTML
## 請填寫:
* 配置文件內容
* 主要功能描述
* 保證不會幹擾到其他用戶和服務器運行

HTML;

return $rpL;


