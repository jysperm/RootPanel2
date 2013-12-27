<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["log.type.signup"] = "注冊了帳號";
$rpL["log.type.delete"] = "刪除了帳號";

$rpL["log.type.createTicket"] = "創建了工單 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.replyTicket"] = "回複了工單 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.closeTicket"] = "關閉了工單 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.createVHost"] = "創建了站點 <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.editVHost"] = "編輯了站點 <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.deleteVHost"] = "刪除了站點 # %s";

$rpL["log.type.panelPasswd"] = "修改了面板密碼";
$rpL["log.type.mysqlPasswd"] = "修改了MySQL密碼";
$rpL["log.type.pptpPasswd"] = "修改了PPTP密碼";
$rpL["log.type.sshPasswd"] = "修改了SSH密碼";

$rpL["log.type.adminReplyTicket"] = "管理員回複了工單 <a href='/ticket/view/%s/'># %s</a>";

$rpL["log.type.addTime"] = "被增加了 %s 天的使用時長";
$rpL["log.type.adminCreateTicket"] = "管理員與妳創建了工單 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.adminCloseTicket"] = "管理員關閉了工單 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.finishTicket"] = "管理員將工單 <a href='/ticket/view/%s/'># %s</a>標記爲已完成";

return $rpL;