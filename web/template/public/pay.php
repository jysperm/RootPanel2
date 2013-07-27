<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["contact", "form", "pay"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = l("pay.buy");
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#pay"><i class="icon-chevron-right"></i> <?= l("pay.buy");?></a></li>
<li><a href="#position"><i class="icon-chevron-right"></i> <?= l("pay.positionList");?></a></li>
<li><a href="#agreement"><i class="icon-chevron-right"></i> <?= l("pay.agreement");?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<section id="pay">
    <header><?= l("pay.buy");?></header>
    <? if(!rpAuth::login()): ?>
        <div class="alert alert-block alert-error fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading"><?= l("form.alert");?></h4>
            <p><?= l("pay.info.noAccount");?></p>
            <p>
                <a class="btn btn-info btn-inline" href="/user/signup/"><?= l("pay.signup");?></a>
            </p>
        </div>
    <? else: ?>
        <? if(!f("rpUserModel")->isAllowToPanel()): ?>
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading"><?= l("form.notice");?></h4>
                <?= l("pay.info.notPay");?>
            </div>
        <? else: ?>
            <div class="alert alert-block alert-success fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading"><?= l("form.notice");?></h4>

                <p><?= l("pay.info.alreadyBy");?></p>
            </div>
        <? endif; ?>
    <? endif;?>
    <div class="row-fluid">
        <div class="span4">
            <h3><?= l("pay.type.free");?></h3>
            <p><?= l("pay.price.free");?></p>
            <p>
                <a class="btn btn-success" href="/ticket/list/?template=freeRequest"><?= l("pay.apply");?></a>
            </p>
        </div>
        <div class="span4">
            <h3><?= l("pay.type.std");?></h3>
            <p><?= l("pay.price.std");?></p>
            <p>
                <a class="btn btn-success" href="<?= l("pay.urls")["std"]; ?>"><?= l("pay.goPay");?></a>
            </p>
        </div>
        <div class="span4">
            <h3><?= l("pay.type.ext");?></h3>
            <p><?= l("pay.price.ext");?></p>
            <p>
                <a class="btn btn-success" href="<?= l("pay.urls")["ext"]; ?>"><?= l("pay.goPay");?></a>
            </p>
        </div>
    </div>
    <hr/>
    <p>
        <?= l("pay.info.pay", rpAuth::uname());?>
    </p>
</section>

<section id="position">
    <div class="page-header">
        <h1><?= l("pay.positionList");?></h1>
    </div>
    <? lpTemplate::outputFile(rpROOT . "/template/widget/node-list.php");?>
</section>

<? lpTemplate::outputFile(f("lpLocale")->file("template/agreement.php")); ?>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>

