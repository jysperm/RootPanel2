<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["log.type.signup"] = "注册了帐号";
$rpL["log.type.delete"] = "删除了帐号";

$rpL["log.type.createTicket"] = "创建了工单 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.replyTicket"] = "回复了工单 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.closeTicket"] = "关闭了工单 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.createVHost"] = "创建了站点 <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.editVHost"] = "编辑了站点 <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.deleteVHost"] = "删除了站点 # %s";

$rpL["log.type.panelPasswd"] = "修改了面板密码";
$rpL["log.type.mysqlPasswd"] = "修改了MySQL密码";
$rpL["log.type.pptpPasswd"] = "修改了PPTP密码";
$rpL["log.type.sshPasswd"] = "修改了SSH密码";

$rpL["log.type.adminReplyTicket"] = "管理员回复了工单 <a href='/ticket/view/%s/'># %s</a>";

$rpL["log.type.addTime"] = "被增加了 %s 天的使用时长";
$rpL["log.type.adminCreateTicket"] = "管理员与你创建了工单 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.adminCloseTicket"] = "管理员关闭了工单 <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.finishTicket"] = "管理员将工单 <a href='/ticket/view/%s/'># %s</a>标记为已完成";

return $rpL;