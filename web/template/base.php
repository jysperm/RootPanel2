<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

<<<<<<< HEAD:web/template/base.php
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
=======
if(rpAuth::uname())
{
    $tkOpen = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::OPEN]);
    $tkHold = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::HODE]);
    $tkFinish = rpTicketModel::count(["uname" => rpAuth::uname(), "status" => rpTicketModel::FINISH]);

    $tkTitle = <<< TEXT
    开放工单：{$tkOpen}
    待处理工单：{$tkHold}
    已处理工单：{$tkFinish}
TEXT;
}
>>>>>>> refs/remotes/origin/master:panel/template/base.php

    $tkTitle = sprintf($rpL["base.tkTitle"], $tkOpen, $tkHold, $tkFinish);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this["title"] ? "{$this["title"]} | " : ""; ?><?= $rpL["global.titleSuffix"]; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/style/icon.png"/>
    <link href='/LightPHP/lp-style/bootstrap-2.2.2/css/bootstrap.css' rel='stylesheet' type='text/css'/>
    <link href='/LightPHP/lp-style/bootstrap-2.2.2/css/bootstrap-responsive.css' rel='stylesheet' type='text/css'/>
    <link href="/style/global.css" rel="stylesheet" type="text/css"/>
    <?= isset($header) ? $header : ""; ?>
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
            <a class="brand" href="/"><?= $rpCfg["NodeName"]; ?></a>

            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="/public/pay/"><i class="icon-shopping-cart icon-white"></i><?= $rpL["global.buy"]; ?></a></li>
                    <li><a href="http://wiki.jyprince.me/rp:user_manual"><?= $rpL["global.manual"]; ?></a></li>
                    <li><a href="/public/review/"><?= $rpL["global.review"]; ?></a></li>
                    <li><a href="/public/sites/"><?= $rpL["global.sites"]; ?></a></li>
                    <li><a href="https://groups.google.com/d/forum/rphost"><?= $rpL["global.bbs"]; ?></a></li>
                </ul>
                <ul class="nav pull-right">
                    <? if(rpAuth::login()): ?>
                        <li><a><?= rpAuth::uname(); ?></a></li>
                        <? if($tkOpen + $tkHold + $tkFinish != 0): ?>
                        <li>
                            <a href="/ticket/" title="<?= $tkTitle;?>">
                                <?= $tkOpen ? "<i class='icon-play icon-white''></i> {$tkOpen}" : ""; ?>
                                <?= $tkHold ? "<i class='icon-step-forward icon-white''></i> {$tkHold}" : ""; ?>
                                <?= $tkFinish ? "<i class='icon-ok icon-white''></i> {$tkFinish}" : ""; ?>
                            </a>
                        </li>
                        <? endif; ?>
                        <? if(!lpFactory::get("rpUserModel")->isAllowToPanel()): ?>
                            <li><a href="/ticket/list/?template=freeRequest"><i class="icon-gift icon-white"></i><?= $rpL["global.pay-free"]; ?>
                                </a></li>
                        <? endif; ?>
                        <li><a href="/panel/"><i class="icon-list-alt icon-white"></i><?= $rpL["global.panel"]; ?></a>
                        </li>
                        <li><a href="/user/logout/"><i class="icon-off icon-white"></i><?= $rpL["global.logout"]; ?></a>
                        </li>
                    <? else: ?>
                        <li><a href="/user/signup/"><i class="icon-edit icon-white"></i><?= $rpL["global.signup"]; ?>
                            </a>
                        </li>
                        <li><a href="/user/login/"><i class="icon-user icon-white"></i><?= $rpL["global.login"]; ?></a>
                        </li>
                    <? endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row-fluid">
        <? if(isset($sidenav)): ?>
            <div class="span3 sidenav-bar">
                <ul data-spy="affix" class="affix nav nav-list sidenav">
                    <?= $sidenav; ?>
                </ul>
            </div>
        <? endif; ?>
        <div class="<?= !isset($sidebar) && !isset($sidenav) ? "span12" : "span9"; ?>">
            <?= $this["content"]; ?>
        </div>
        <? if(isset($sidebar)): ?>
            <div class="span3 sidebar">
                <?= $sidebar; ?>
            </div>
        <? endif; ?>
    </div>
    <div class="pull-right" style="margin-top: 40px;">
        <script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
        <?= "RootPanel {$rpCfg["Version"]["main"]} {$rpCfg["Version"]["time"]} {$rpCfg["Version"]["type"]}"; ?>
    </div>
</div>
<script type='text/javascript' src='/LightPHP/lp-style/jquery-1.9.1/jquery.js'></script>
<script type='text/javascript' src='/LightPHP/lp-style/bootstrap-2.2.2/js/bootstrap.js'></script>
<script type="text/javascript">
    $("a[rel=tooltip]").tooltip({trigger: "hover", html: true, placement: "top"});
    $("a[rel=popover]").popover({trigger: "hover", html: true, placement: "top"});
    $("a[rel=popover-click]").popover({html: true, placement: "top"}).show();
    $('a[href=#]').click(function (e) {
        e.preventDefault()
    })
</script>
<!--[if lte IE 8]>
<script type='text/javascript' src='/locale/zh_CN/script/kill-ie6.js'></script>
<![endif]-->
<?= isset($endOfBody) ? $endOfBody : ""; ?>
</body>
</html>
