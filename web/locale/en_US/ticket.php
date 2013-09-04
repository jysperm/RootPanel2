<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["ticket.title"] = "Tickets";
$rpL["ticket.ticketList"] = "Tickets #%s";
$rpL["ticket.create"] = "Create a ticket";

$rpL["ticket.list.id"] = "ID";
$rpL["ticket.list.type"] = "Type";
$rpL["ticket.list.status"] = "Status";
$rpL["ticket.list.title"] = "Title";
$rpL["ticket.list.reply"] = "Reply";

$rpL["ticket.nav.opeator"] = "Action";
$rpL["ticket.nav.returnList"] = "Back to the list";
$rpL["ticket.nav.returnPanel"] = "Back to the control panel";

$rpL["ticket.opeator.close"] = "Close ticket";
$rpL["ticket.opeator.finish"] = "Mark as finished";
$rpL["ticket.opeator.content"] = "Content";
$rpL["ticket.opeator.reply"] = "Reply";
$rpL["ticket.opeator.closed"] = "The ticket is closed";

$rpL["ticket.replyBy"] = "%s replies | %s at %s";

$rpL["ticket.create.content"] = "Content";
$rpL["ticket.create.create"] = "Create a ticket";

$rpL["ticket.types"] = [
    "pay" => "Sales",
    "panel" => "Control panel support",
    "miao" => "Take a shit on JYPrince XD",
    "web" => "Web Environment",
    "linux" => "Linux Environment",
    "runtime" => "Language Supports"
];
$rpL["ticket.types.default"] = "miao";

$rpL["ticket.types.long"] = [
    "pay" => "Sales",
    "panel" => "Control panel support/Bug Report",
    "miao" => "Take a shit on JYPrince XD",
    "web" => "Web Environment(Nginx/Apache2)",
    "linux" => "Linux Environment",
    "runtime" => "Language Supports(PHP/Python etc)"
];

$rpL["ticket.status.open"] = "Open";
$rpL["ticket.status.hode"] = "Replied";
$rpL["ticket.status.finish"] = "Solved";
$rpL["ticket.status.closed"] = "Closed";

$rpL["ticket.handler.invalidType"] = "The ticket type is invalid";
$rpL["ticket.handler.invalidID"] = "Invalid ticket ID";
$rpL["ticket.handler.invalidPermission"] = "You do not have permission of this ticket";
$rpL["ticket.handler.alreadyClosed"] = "This ticket has been closed";
$rpL["ticket.handler.closeOnlyByAdmin"] = "This ticket can only be closed by the Administrator";
$rpL["ticket.handler.notAdmin"] = "Only administrators can mark is as finished.";

$rpL["ticket.createMail.title"] = "TK Create | %s | %s | %s";
$rpL["ticket.createMail.body"] = <<< HTML
%s<br /><a href='http://%s/ticket/view/%s/'># %s | %s</a>
HTML;


$rpL["ticket.template"]["freeRequest"]["title"] = "Apply for a free trail";
$rpL["ticket.template"]["freeRequest"]["type"] = "pay";
$rpL["ticket.template"]["freeRequest"]["content"] = <<< HTML
## Please fill up the following fields(Around 100-300 words)
* Age, Career
* How do you know RP Host
* Can you do programming. If you can, please indicate what you are good at of programming.
* What would you do on RP Host.
* Why would you like to try it first but do not purchase directly.

HTML;

$rpL["ticket.template"]["configRequest"]["title"] = "Configuration file cencership";
$rpL["ticket.template"]["configRequest"]["type"] = "web";
$rpL["ticket.template"]["configRequest"]["content"] = <<< HTML
## Please indicate:
* the content of the configuration file
* Please describe the function of it
* Are you sure that it will not affect other users

HTML;

$rpL["ticket.admin.title"] = "Tickets";
$rpL["ticket.admin.openTicket"] = "Open Tickets";
$rpL["ticket.admin.allTicket"] = "All Tickets";

$rpL["ticket.admin.objUser"] = "Target user";
$rpL["ticket.admin.closeOnlyByAdmin"] = "Only administrators can close this ticket";

return $rpL;


