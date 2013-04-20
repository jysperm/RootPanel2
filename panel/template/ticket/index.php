<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = $titile = "工单 #{$page}";

$rows = rpApp::q("Ticket")->where(["uname" => rpAuth::uname()])->select()->num();
$dPage = new lpDividePage($rows, $page, $rpCfg["TKPerPage"]);

$tks = rpApp::q("Ticket")->where(["uname" => rpAuth::uname()])->sort("time", false)->limit($rpCfg["TKPerPage"])->skip($dPage->getPos())->select();
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> 工单列表 #<?= $page; ?></a></li>
<li><a href="#section-new"><i class="icon-chevron-right"></i> 创建工单</a></li>
<? $base->sidenav = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        table-layout: fixed;
        word-break: break-all;
    }

    textarea {
        width: 530px;
    }
</style>
<? $base->header = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript'>
    $($("form").submit(function () {
        $.post("/ticket/create/", $("form").serializeArray(), function (data) {
            if (data.status == "ok")
                window.location.reload();
            else
                alert(data.msg);
        }, "json");
        return false;
    }));
</script>
<? $base->endOfBody = lpTemplate::endBlock(); ?>

<section id="section-list">
    <header>工单列表 #<?= $page; ?></header>
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
        <? while($tks->read()): ?>
            <tr>
                <td><?= $tks["id"]; ?></td>
                <td><?= $rpL["ticket.types"][$tks["type"]]; ?></td>
                <td><?= $rpL[$tks["status"]]; ?></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $tks["lastchange"]); ?>"><?= rpTools::niceTime($tks["lastchange"]); ?></span>
                </td>
                <td><a href="/ticket/view/<?= $tks["id"]; ?>/"><?= $tks["title"]; ?></a></td>
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

<section id="section-new">
    <header>创建工单</header>
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="title">标题</label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="title" name="title" required="required"/>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type">类型</label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach($rpL["ticket.types"] as $k => $v): ?>
                            <option
                                value="<?= $k; ?>" <?= $k == "miao" ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                        <? endforeach; ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="content">内容</label>

            <div class="controls">
                <label class="radio">
                    <textarea id="content" name="content" rows="10"></textarea><br/>
                </label>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">创建</button>
        </div>
    </form>
</section>

<? $base->output(); ?>
