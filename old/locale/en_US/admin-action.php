<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["admin-action.notLogin"] = "You have not logged in";
$rpL["admin-action.notAdmin"] = "You are not an administrator";

$rpL["admin-action.ticket.alert.title"] = "Your account will expire on %s ";
$rpL["admin-action.ticket.alert.content"] = <<<HTML
Your account will expire on %s .<br />
<br />
Please pay the fee in the control panel in time or your data would be deleted permanently.
Please contact our administrators if you have any questions.
HTML;

$rpL["admin-action.ticket.enable.title"] = "Your account has been activated as %s";
$rpL["admin-action.ticket.enable.content"] = <<<HTML
Your account has been activated as %s。<br />
<br />
If you encounter any problems, please contact our customer service agent.
HTML;

$rpL["admin-action.ticket.diasble.title"] = "Your data has been deleted";
$rpL["admin-action.ticket.diasble.content"] = <<<HTML
Your data has been deleted due to an overdue invoice.
Please contact our administators if you have any questions.
HTML;


return $rpL;