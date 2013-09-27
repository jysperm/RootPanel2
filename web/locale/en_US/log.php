<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["log.type.signup"] = "has signed up";
$rpL["log.type.delete"] = "has deleted the account";

$rpL["log.type.createTicket"] = "has created a ticket <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.replyTicket"] = "has replied to a ticket <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.closeTicket"] = "has closed a ticket <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.createVHost"] = "has created a website <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.editVHost"] = "has edited a website <a href='/panel/#website%s'># %s</a>";
$rpL["log.type.deleteVHost"] = "has deleted a website # %s";

$rpL["log.type.panelPasswd"] = "has changed the control panel password";
$rpL["log.type.mysqlPasswd"] = "has changed the password of MySQL";
$rpL["log.type.pptpPasswd"] = "has changed the password of PPTP";
$rpL["log.type.sshPasswd"] = "has changed the password of SSH";

$rpL["log.type.adminReplyTicket"] = "The administrator has replied the ticket <a href='/ticket/view/%s/'># %s</a>";

$rpL["log.type.addTime"] = "Has gained %s more days";
$rpL["log.type.adminCreateTicket"] = "The administrator created the ticket <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.adminCloseTicket"] = "The administrator closed the ticket <a href='/ticket/view/%s/'># %s</a>";
$rpL["log.type.finishTicket"] = "The administrator marked the ticket <a href='/ticket/view/%s/'># %s</a> as finished";

return $rpL;