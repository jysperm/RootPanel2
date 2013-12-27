<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["base", "logs", "log"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$page = lpDividePage::fromGET();

$base['title'] = $titile = l("logs.title", $page);

if (lpFactory::get("rpUserModel")->isAdmin())
    $ifSelect = $this["uname"] ? ["uname" => $this["uname"]] : [];
else
    $ifSelect = ["uname" => rpAuth::uname()];

$rows = rpLogModel::count($ifSelect);
$dPage = new lpDividePage($rows, $page, c("LogPerPage"));

function printArray($arr, $tab = 0)
{
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            echo str_repeat(" &nbsp; ", $tab) . "<b>{$k}</b>:<br />";
            printArray($v, $tab + 1);
        } else {
            echo str_repeat(" &nbsp; ", $tab) . "<b>{$k}</b>: {$v}<br />";
        }
    }
}

?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        word-break: break-all;
    }

    section .pull-right {
        margin-top: 30px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<section>
    <a href="/panel/" class="btn btn-info pull-right"><?= l("logs.returnPanel"); ?></a>
    <header><?= l("logs.detailLog"); ?> <span
            class="text-small-per50 not-bold"><?= l("logs.pageInfo", $page, $rows); ?></span></header>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th style="min-width: 50px;"><a href="#" rel="tooltip"
                                            title="<?= l("logs.tooltip.logid"); ?>"><?= l("logs.id"); ?></a>
            </th>
            <th style="min-width: 90px;"><a href="#" rel="tooltip"
                                            title="<?= l("logs.tooltip.by"); ?>"><?= $ifSelect ? "" : l("logs.user"); ?><?= l("logs.actionBy"); ?></a>
            </th>
            <th style="min-width: 90px;"><a href="#" rel="tooltip"
                                            title="<?= l("logs.tooltip.ipua"); ?>"><?= l("logs.ipua"); ?></a>
            </th>
            <th style="min-width: 90px;"><?= l("logs.time"); ?></th>
            <th><?= l("logs.detail"); ?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach (rpLogModel::select($ifSelect, ["sort" => ["time", false], "limit" => c("LogPerPage"), "skip" => $dPage->getPos()]) as $log): ?>
            <tr>
                <td><?= $log["id"]; ?></td>
                <td><?= ($ifSelect || $log["by"] == $log["uname"]) ? "" : "({$log["uname"]}) "; ?><?= $log["by"]; ?></td>
                <td><span title="<?= htmlentities($log["ua"]); ?>"><?= $log["ip"]; ?></span></td>
                <td><span
                        title="<?= gmdate(l("base.fullTime"), $log["time"]); ?>"><?= rpTools::niceTime($log["time"]); ?></span>
                </td>
                <? $args = json_decode($log["info"]); ?>
                <td>

                    <?= vsprintf(l($log["type"]), $args); ?><? if ($detail = json_decode($log["detail"], true)): ?> |
                        <a data-toggle="collapse" href="#detail<?= $log["id"]; ?>">
                            <?= l("logs.detail"); ?>
                        </a>
                        <div id="detail<?= $log["id"]; ?>" class="accordion-body collapse">
                            <? printArray($detail); ?>
                        </div>
                    <? endif; ?>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <?=
            $dPage->getOutput(function ($page, $curPage) use ($ifSelect) {
                if ($curPage == $page || $page == lpDividePage::splitter)
                    return "<li class='active'><a href='#'>{$page}</a></li>";
                else
                    return $ifSelect ? "<li><a href='/panel/logs/?p={$page}'>{$page}</a></li>" : "<li><a href='/admin/logs/?p={$page}'>{$page}</a></li>";
            }); ?>
        </ul>
    </div>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
