<?php

global $rpROOT, $rpCfg, $popover, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$page = lpDividePage::fromGET();

$base['title'] = $titile = "详细日志 #{$page}";

if(lpFactory::get("rpUserModel")->isAdmin())
    $ifSelect = $this["uname"] ? ["uname" => $this["uname"]] : [];
else
    $ifSelect = ["uname" => rpAuth::uname()];

$rows = rpLogModel::count($ifSelect);
$dPage = new lpDividePage($rows, $page, $rpCfg["LogPerPage"]);

function printArray($arr, $tab=0)
{
    foreach($arr as $k => $v)
    {
        if(is_array($v))
        {
            echo str_repeat(" &nbsp; ", $tab) . "<b>{$k}</b>:<br />";
            printArray($v, $tab+1);
        }
        else
        {
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
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<section>
    <a href="/panel" style="margin-top: 30px;" class="btn btn-info pull-right">返回面板</a>
    <header>详细日志 <span class="text-small-per50 not-bold">#<?= $page; ?> (共<?= $rows; ?>)</span></header>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th style="min-width: 50px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.logid"]; ?>">ID</a>
            </th>
            <th style="min-width: 90px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.by"]; ?>"><?= $ifSelect ?"": "(用户)"; ?>操作者</a></th>
            <th style="min-width: 90px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.ipua"]; ?>">IP/UA</a>
            </th>
            <th style="min-width: 90px;">时间</th>
            <th>详情</th>
        </tr>
        </thead>
        <tbody>
        <? foreach(rpLogModel::select($ifSelect, ["sort" => ["time", false], "limit" => $rpCfg["LogPerPage"], "skip" => $dPage->getPos()]) as $log): ?>
            <tr>
                <td><?= $log["id"]; ?></td>
                <td><?= ($ifSelect || $log["by"]==$log["uname"]) ?"": "({$log["uname"]}) "; ?><?= $log["by"]; ?></td>
                <td><span title="<?= htmlentities($log["ua"]); ?>"><?= $log["ip"]; ?></span></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $log["time"]); ?>"><?= rpTools::niceTime($log["time"]); ?></span>
                </td>
                <? $args = json_decode($log["info"]);
                ?>
                <td>
                    <?= vsprintf($rpL[$log["type"]], $args); ?> |
                    <a data-toggle="collapse" href="#detail<?= $log["id"]; ?>">
                        详细
                    </a>

                    <div id="detail<?= $log["id"]; ?>" class="accordion-body collapse">
                        <? printArray(json_decode($log["detail"], true));?>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <?= $dPage->getOutput(function($page, $curPage) use($ifSelect){
                if($curPage == $page || $page == lpDividePage::splitter)
                    return "<li class='active'><a href='#'>{$page}</a></li>";
                else
                    return $ifSelect ? "<li><a href='/panel/logs/?p={$page}'>{$page}</a></li>" : "<li><a href='/admin/logs/?p={$page}'>{$page}</a></li>";
            }); ?>
        </ul>
    </div>
</section>

<? $base->output(); ?>
