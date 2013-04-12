<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = $titile = "工单 #{$page}";

$allPage = ceil(rpApp::q("Ticket")->where(["uname" => rpAuth::uname()])->select()->num() / $rpCfg["TKPerPage"]);
$tks = rpApp::q("Ticket")->where(["uname" => rpAuth::uname()])->where(["replyto" => 0])->sort("time", false)->limit($rpCfg["TKPerPage"])->skip(($page - 1) * $rpCfg["TKPerPage"])->select();
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> 工单列表 #<?= $page;?></a></li>
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
    <header>工单列表</header>
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
            <?php
            $settings = json_decode($tks["settings"], true);
            ?>
            <tr>
                <td><?= $tks["id"];?></td>
                <td><?= $rpL[$settings["type"]];?></td>
                <td><?= $rpL[$settings["status"]];?></td>
                <td><span
                        title="<?= gmdate("Y.m.d H:i:s", $settings["lastchange"]); ?>"><?= rpTools::niceTime($settings["lastchange"]);?></span>
                </td>
                <td><a href="/ticket/view/<?= $tks["id"]; ?>/"><?= $settings["title"];?></a></td>
            </tr>
        <? endwhile; ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul>
            <? for($i = $page - 3; $i < $page; $i++): ?>
                <? if($i > 0): ?>
                    <li><a href="/ticket/list/<?= $i; ?>/"><?= $i;?></a></li>
                <? endif; ?>
            <? endfor;?>
            <li class="active"><a href="#"><?= $page;?></a></li>
            <? for($i = $page + 1; $i <= $page + 3; $i++): ?>
                <? if($i <= $allPage): ?>
                    <li><a href="/ticket/list/<?= $i; ?>/"><?= $i;?></a></li>
                <? endif; ?>
            <? endfor;?>
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
                    <input type="text" class="input-xxlarge" id="title" name="title"/>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type">类型</label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach(["pay", "miao", "panel", "web", "linux", "runtime"] as $i): ?>
                            <option
                                value="ticket.type.<?= $i; ?>" <?= $i == "miao" ? 'selected="selected"' : "";?>><?= $rpL["ticket.type.{$i}"];?></option>
                        <? endforeach;?>
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
