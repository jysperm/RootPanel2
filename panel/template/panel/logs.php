<?php

global $rpROOT, $rpCfg, $tooltip, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = $titile = "详细日志 #{$page}";

$rows = rpApp::q("Log")->where(["uname" => rpAuth::uname()])->select()->num();
$dPage = new lpDividePage($rows, $page, $rpCfg["LogPerPage"]);

$logs = rpApp::q("log")->where(["uname" => rpAuth::uname()])->sort("time", false)->limit($rpCfg["LogPerPage"])->skip($dPage->getPos())->select();
?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        table-layout: fixed;
        word-break: break-all;
    }
</style>
<? $base->header = lpTemplate::endBlock(); ?>

<section>
    <a href="/panel" style="margin-top: 30px;" class="btn btn-info pull-right">返回面板</a>
    <header>详细日志 <span class="text-small-per50 not-bold">#<?= $page; ?> (共<?= $rows; ?>)</span></header>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th style="width: 40px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.logid"]; ?>">ID</a></th>
            <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.by"]; ?>">操作者</a></th>
            <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $rpL["logs.tooltip.ipua"]; ?>">IP/UA</a></th>
            <th style="width: 60px;">时间</th>
            <th style="width: 100px;">摘要</th>
            <th>详情</th>
        </tr>
        </thead>
        <tbody>
        <? while($logs->read()): ?>
            <tr>
                <td><?= $logs["id"]; ?></td>
                <td><?= $logs["by"]; ?></td>
                <td><span title="<?= htmlentities($logs["ua"]); ?>"><?= $logs["ip"]; ?></span></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $logs["time"]); ?>"><?= rpTools::niceTime($logs["time"]); ?></span>
                </td>
                <? $args = json_decode($logs["info"]);
                array_unshift($args, $rpL[$logs["type"]]);
                ?>
                <td><?= htmlentities(call_user_func_array("sprintf", $args)); ?></td>
                <td>
                    <?php
                    $detail = json_decode($logs["detail"]);
                    foreach($detail as $k => $v) {
                        $v = nl2br(htmlentities($v));
                        echo "<b>{$k}</b>: {$v}<br />";
                    }
                    ?>
                </td>
            </tr>
        <? endwhile; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <?= $dPage->getOutput(new rpDividePageMaker); ?>
        </ul>
    </div>
</section>

<? $base->output(); ?>
