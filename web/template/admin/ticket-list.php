<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/** @var lpLocale $rpL */
$rpL = f("lpLocale");

$rpL->load(["base", "ticket"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$page = lpDividePage::fromGET();

$base['title'] = l("ticket.admin.title");

$ifUName = [];
if($this["uname"])
    $ifUName = ["uname" => $this["uname"]];

$rows = rpTicketModel::count($ifUName);
$dPage = new lpDividePage($rows, $page, c("TKPerPage"));

?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> <?= l("ticket.ticketList", $page);?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        word-break: break-all;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<section id="section-list">
    <header><?= l("ticket.ticketList", $page);?></header>
    <h2><?= l("ticket.admin.openTicket");?></h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("ticket.list.id");?></th>
            <th><?= l("ticket.list.type");?></th>
            <th><?= l("ticket.list.status");?></th>
            <th><?= l("ticket.list.title");?></th>
            <th><?= l("ticket.list.reply");?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select(["status" => rpTicketModel::OPEN], ["sort" => ["lastchange", false]]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL["ticket.types"][$tk["type"]]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                <td>
                    <?= l("ticket.replyBy", rpTicketReplyModel::count(["replyto" => $tk["id"]]), $tk["lastreply"],
                        "<span title='" . gmdate(l("base.fullTime"), $tk["lastchange"]) . "'>" . rpTools::niceTime($tk["lastchange"]) . "</span>");?>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <h2><?= l("ticket.admin.allTicket");?></h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("ticket.list.id");?></th>
            <th><?= l("ticket.list.type");?></th>
            <th><?= l("ticket.list.status");?></th>
            <th><?= l("ticket.list.title");?></th>
            <th><?= l("ticket.list.reply");?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpTicketModel::select($ifUName, ["sort" => ["lastchange", false], "limit" => c("TKPerPage"), "skip" => $dPage->getPos()]) as $tk): ?>
            <tr>
                <td><?= $tk["id"]; ?></td>
                <td><?= $rpL["ticket.types"][$tk["type"]]; ?></td>
                <td><?= $rpL[$tk["status"]]; ?></td>
                <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                <td>
                    <?= l("ticket.replyBy", rpTicketReplyModel::count(["replyto" => $tk["id"]]), $tk["lastreply"],
                        "<span title='" . gmdate(l("base.fullTime"), $tk["lastchange"]) . "'>" . rpTools::niceTime($tk["lastchange"]) . "</span>");?>
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
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
