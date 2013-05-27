<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base['title'] = $titile = "工单";

$page = lpDividePage::fromGET();
$rows = rpTicketModel::count(["uname" => rpAuth::uname()]);
$dPage = new lpDividePage($rows, $page, $rpCfg["TKPerPage"]);

$ifUName = [];
if($this["uname"])
    $ifUName = ["uname" => $this["uname"]];

?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> 工单列表 #<?= $page; ?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
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
            <th>ID</th>
            <th>状态</th>
            <th>标题</th>
            <th>回复</th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select(["status" => rpTicketModel::OPEN], ["sort" => ["lastchange", false]]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                <td>
                    <?= rpTicketReplyModel::count(["replyto" => $tk["id"]]);?> 个回复 | <?= $tk["lastreply"];?> 于
                    <span title="<?= gmdate("Y.m.d H:i:s", $tk["lastchange"]); ?>"><?= rpTools::niceTime($tk["lastchange"]); ?></span>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <h2>所有工单</h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>ID</th>
            <th>类型</th>
            <th>状态</th>
            <th>标题</th>
            <th>回复</th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select($ifUName, ["sort" => ["lastchange", false], "limit" => $rpCfg["TKPerPage"], "skip" => $dPage->getPos()]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL["ticket.types"][$tk["type"]]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                <td>
                    <?= rpTicketReplyModel::count(["replyto" => $tk["id"]]);?> 个回复 | <?= $tk["lastreply"];?> 于
                    <span title="<?= gmdate("Y.m.d H:i:s", $tk["lastchange"]); ?>"><?= rpTools::niceTime($tk["lastchange"]); ?></span>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <?= $dPage->getOutput(function($page, $curPage){
                if($curPage == $page || $page == lpDividePage::splitter)
                    return "<li class='active'><a href='#'>{$page}</a></li>";
                else
                    return "<li><a href='/admin/ticket/?p={$page}'>{$page}</a></li>";
            }); ?>
        </ul>
    </div>
</section>



<? $base->output(); ?>
