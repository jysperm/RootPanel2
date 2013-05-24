<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base['title'] = $titile = "工单";

$page = lpDividePage::fromGET();
$rows = rpTicketModel::count(["uname" => rpAuth::uname()]);
$dPage = new lpDividePage($rows, $page, $rpCfg["TKPerPage"]);

?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> 工单列表 #<?= $page; ?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        table-layout: fixed;
        word-break: break-all;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<section id="section-list">
    <header>工单列表 #<?= $page; ?></header>
    <h2>开放工单</h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th style="width: 35px;">ID</th>
            <th style="width: 75px;">状态</th>
            <th style="width: 110px;">最后回复</th>
            <th>标题</th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select(["status" => rpTicketModel::OPEN], ["sort" => ["lastchange", false]]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $tk["lastchange"]); ?>"><?= rpTools::niceTime($tk["lastchange"]); ?></span>
                </td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <h2>所有工单</h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th style="width: 35px;">ID</th>
            <th style="width: 75px;">类型</th>
            <th style="width: 75px;">状态</th>
            <th style="width: 110px;">最后回复</th>
            <th>标题</th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select([], ["sort" => ["lastchange", false], "limit" => $rpCfg["TKPerPage"], "skip" => $dPage->getPos()]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL["ticket.types"][$tk["type"]]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $tk["lastchange"]); ?>"><?= rpTools::niceTime($tk["lastchange"]); ?></span>
                </td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <?= $dPage->getOutput(new rpDividePageMaker("/ticket/list")); ?>
        </ul>
    </div>
</section>

<? $base->output(); ?>
