<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/** @var lpConfig $rpCfg */
$rpCfg = f("lpConfig");
/** @var lpLocale $rpL */
$rpL = f("lpLocale");

$rpL->load("base");

if(rpAuth::login())
{
    $tkOpen = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::OPEN]);
    $tkHold = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::HODE]);
    $tkFinish = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::FINISH]);

    $tkTitle = sprintf(l("base.tkTitle"), $tkOpen, $tkHold, $tkFinish);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this["title"] ? "{$this["title"]} | " : ""; ?><?= l("base.titleSuffix"); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= c("StaticPrefix");?>/style/icon.png"/>
    <link href='<?= c("BootstrapPrefix");?>/css/bootstrap.css' rel='stylesheet' type='text/css'/>
    <link href='<?= c("BootstrapPrefix");?>/css/bootstrap-responsive.css' rel='stylesheet' type='text/css'/>
    <link href="<?= c("StaticPrefix");?>/style/global.css" rel="stylesheet" type="text/css"/>
    <?= $this["header"]; ?>
</head>
<body data-spy="scroll" data-target=".sidenav-bar" screen_capture_injected="true" class="well">
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/"><?= c("NodeName"); ?></a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="/public/pay/"><i class="icon-shopping-cart icon-white"></i><?= l("base.buy"); ?></a></li>
                    <li><a href="http://wiki.jyprince.me/rp:user_manual"><?= l("base.manual"); ?></a></li>
                    <li><a href="/public/review/"><?= l("base.review"); ?></a></li>
                    <li><a href="/public/sites/"><?= l("base.sites"); ?></a></li>
                    <li><a href="https://groups.google.com/d/forum/rphost"><?= l("base.bbs"); ?></a></li>
                </ul>
                <ul class="nav pull-right">
                    <? if(rpAuth::login()): ?>
                        <li><a><?= rpAuth::uname(); ?></a></li>
                        <? if($tkOpen + $tkHold + $tkFinish != 0): ?>
                        <li>
                            <a href="/ticket/" title="<?= $tkTitle;?>">
                                <?= $tkOpen ? "<i class='icon-play icon-white'></i> {$tkOpen}" : "";?>
                                <?= $tkHold ? "<i class='icon-step-forward icon-white'></i> {$tkHold}" : "";?>
                                <?= $tkFinish ? "<i class='icon-ok icon-white'></i> {$tkFinish}" : "";?>
                            </a>
                        </li>
                        <? endif; ?>
                        <? if(!f("rpUserModel")->isAllowToPanel()): ?>
                            <li><a href="/ticket/list/?template=freeRequest"><i class="icon-gift icon-white"></i><?= l("base.pay-free"); ?></a></li>
                        <? endif; ?>
                        <li><a href="/panel/"><i class="icon-list-alt icon-white"></i><?= l("base.panel"); ?></a></li>
                        <li><a href="/user/logout/"><i class="icon-off icon-white"></i><?= l("base.logout"); ?></a></li>
                    <? else: ?>
                        <li><a href="/user/signup/"><i class="icon-edit icon-white"></i><?= l("base.signup"); ?></a></li>
                        <li><a href="/user/login/"><i class="icon-user icon-white"></i><?= l("base.login"); ?></a></li>
                    <? endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row-fluid">
        <? if($this["sidenav"]): ?>
            <div class="span3 sidenav-bar">
                <ul data-spy="affix" class="affix nav nav-list sidenav">
                    <?= $this["sidenav"];?>
                </ul>
            </div>
        <? endif; ?>
        <div class="<?= !$this["sidebar"] && !$this["sidenav"] ? "span12" : "span9"; ?>">
            <?= $this["content"];?>
        </div>
        <? if($this["sidebar"]):?>
            <div class="span3 sidebar">
                <?= $this["sidebar"];?>
            </div>
        <? endif; ?>
    </div>
    <div class="pull-right copyright">
        <?= l("base.copyright");?>
    </div>
</div>
<script type='text/javascript' src='<?= c("jQueryPrefix");?>/jquery.js'></script>
<script type='text/javascript' src='<?= c("BootstrapPrefix");?>/js/bootstrap.js'></script>
<script type="text/javascript">
    $("a[rel=tooltip]").tooltip({trigger: "hover", html: true, placement: "top"});
    $("a[rel=popover]").popover({trigger: "hover", html: true, placement: "top"});
    $("a[rel=popover-click]").popover({html: true, placement: "top"}).show();
    $('a[href=#]').click(function (e) {
        e.preventDefault()
    });
</script>
<!--[if lte IE 8]>
    <script type='text/javascript' src="<?= "{$rpCfg["StaticPrefix"]}/locale/{$rpCfg["DefaultLanguage"]}/kill-ie6.js";?>"></script>
<![endif]-->
<?= $this["endOfBody"]; ?>
</body>
</html>
