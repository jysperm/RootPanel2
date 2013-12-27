<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$types = rpVHostType::loadTypes();

f("lpLocale")->load(["base", "panel", "form", "log"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$base["title"] = l("panel.title");

$me = f("rpUserModel");
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#section-index"><i class="icon-chevron-right"></i> <?= l("panel.index"); ?></a></li>
<? if ($me->isAllowToPanel()): ?>
    <li><a href="#section-access"><i class="icon-chevron-right"></i> <?= l("panel.access"); ?></a></li>
    <li><a href="#section-website"><i class="icon-chevron-right"></i> <?= l("panel.website"); ?></a></li>
<? endif; ?>
<li><a href="#section-log"><i class="icon-chevron-right"></i> <?= l("panel.log"); ?></a></li>
<li><a href="/panel/logs/"><i class="icon-share"></i> <?= l("panel.fullLog"); ?></a></li>
<li><a href="/ticket/"><i class="icon-share"></i> <?= l("panel.ticket"); ?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    .input-xxlarge {
        width: 250px;
    }

    #section-access button {
        margin-bottom: 10px;
    }

    .box .btn-info {
        margin-right: 10px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript'
        src='<?= c("StaticPrefix"); ?>/locale/<?= f("lpLocale")->language(); ?>/locale.js'></script>
<script type='text/javascript' src='<?= c("StaticPrefix"); ?>/script/panel.js'></script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<div class="modal hide" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialogLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="dialogLabel" class="dialog-title"></h3>
    </div>
    <div class="modal-body dialog-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?= l("form.cancel"); ?></button>
        <button class="btn btn-primary dialog-ok"><?= l("form.save"); ?></button>
    </div>
</div>

<section id="section-index">
    <header><?= l("panel.index"); ?></header>
    <p>
        <?= l("panel.userType"); ?><?= l("base.userType")[$me["type"]] ?><br/>
        <?= l("panel.expiredTime"); ?><span
            title="<?= gmdate(l("base.fullTime"), $me["expired"]); ?>"><?= rpTools::niceTime($me["expired"]); ?></span>
        <a class="btn btn-success btn-inline" href="/public/pay/"> <?= l("panel.renew"); ?></a>
    </p>
</section>

<? if ($me->isAllowToPanel()): ?>
    <section id="section-access">
        <header><?= l("panel.access"); ?></header>
        <div>
            <input type="text" class="input-xxlarge" id="sshpasswd" name="sshpasswd"/>
            <button class="btn btn-success" onclick="changePasswd('ssh', false);"><?= l("panel.change.ssh"); ?></button>
        </div>
        <div>
            <input type="text" class="input-xxlarge" id="mysqlpasswd" name="mysqlpasswd"/>
            <button class="btn btn-success"
                    onclick="changePasswd('mysql', false);"><?= l("panel.change.mysql"); ?></button>
        </div>
        <div>
            <input type="text" class="input-xxlarge" id="panelpasswd" name="panelpasswd"/>
            <button class="btn btn-success"
                    onclick="changePasswd('panel', true);"><?= l("panel.change.panel"); ?></button>
        </div>
        <div>
            <input type="text" class="input-xxlarge" id="pptppasswd" name="pptppasswd"/>
            <button class="btn btn-success"
                    onclick="changePasswd('pptp', false);"><?= l("panel.change.pptp"); ?></button>
        </div>
    </section>

    <section id="section-website">
        <header><?= l("panel.website"); ?></header>
        <div>
            <?= l("panel.extConfig"); ?>
            <br/>
            <a class="btn" href="/ticket/list/?template=configRequest"><?= l("panel.change.extConfig"); ?></a>
        </div>
        <hr/>
        <? foreach (rpVirtualHostModel::select(["uname" => rpAuth::uname()]) as $host): ?>
            <div id="website<?= $host["id"]; ?>" class="box">
                <div>
                    <a href="#" rel="tooltip"
                       title="<?= l("panel.tooltip.ison"); ?>"><?= l("panel.website.ison"); ?></a> &raquo; <span
                        class="label"><?= $host["ison"] ? l("form.yes") : l("form.no") ?></span> |
                    <a href="#" rel="tooltip"
                       title="<?= l("panel.tooltip.id"); ?>"><?= l("panel.website.id"); ?></a> &raquo; <span
                        class="label"><?= $host["id"]; ?></span> |
                    <a href="#" rel="tooltip"
                       title="<?= l("panel.tooltip.domain"); ?>"><?= l("panel.website.domain"); ?></a> &raquo; <span
                        class="label"><?= $host["domains"]; ?></span>
                </div>
                <div>
                    <a href="#" rel="tooltip"
                       title="<?= l("panel.tooltip.type"); ?>"><?= l("panel.website.type"); ?></a> &raquo; <span
                        class="label"><?= $types[$host["type"]]->meta()["name"]; ?></span> |
                    <a href="#" rel="tooltip"
                       title="<?= l("panel.tooltip.source"); ?>"><?= l("panel.website.source"); ?></a> &raquo; <span
                        class="label"><?= $host["source"]; ?></span>
                </div>
                <button class="btn btn-danger pull-right"
                        onclick="deleteWebsite(<?= $host["id"]; ?>);return false;"><?= l("form.delete"); ?>
                </button>
                <button class="btn btn-info pull-right"
                        onclick="editWebsite(<?= $host["id"]; ?>);return false;"><?= l("form.change"); ?>
                </button>
            </div>
        <? endforeach; ?>
        <div class="box">
            <button id="new-website" class="btn btn-success pull-right"><?= l("panel.addWebsite"); ?></button>
        </div>
    </section>
<? endif; ?>

<section id="section-log">
    <header><?= l("panel.log"); ?></header>
    <?= l("panel.logSummary"); ?>
    <div>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th><?= l("panel.logs.id"); ?></th>
                <th><?= l("panel.logs.time"); ?></th>
                <th><?= l("panel.logs.summary"); ?></th>
            </tr>
            </thead>
            <tbody>
            <? foreach (rpLogModel::select(["uname" => rpAuth::uname()], ["sort" => ["time", false], "limit" => 15]) as $log): ?>
                <tr>
                    <td><?= $log["id"]; ?></td>
                    <td><span
                            title="<?= gmdate(l("base.fullTime"), $log["time"]); ?>"><?= rpTools::niceTime($log["time"]); ?></span>
                    </td>
                    <? $args = json_decode($log["info"]);
                    array_unshift($args, l($log["type"]));
                    ?>
                    <td><?= call_user_func_array("sprintf", $args); ?></td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <div>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
