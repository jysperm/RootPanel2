<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = $titile = "工单 #{$tk["id"]}";

$tk["settings"] = json_decode($tk["settings"], true);
$replys = rpApp::q("Ticket")->where(["replyto" => $tk["id"]])->select();
?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="/ticket/"><i class="icon-share"></i> 返回工单</a></li>
    <li><a href="/panel/"><i class="icon-share"></i> 返回面板</a></li>
<? $base->sidenav = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <style type="text/css">
        textarea {
            width: 530px;
        }
    </style>
<? $base->header = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <script type='text/javascript'>
        $($("form").submit(function () {
            $.post("/ticket/reply/<?= $tk["id"];?>/", $("form").serializeArray(), function (data) {
                if (data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        }));
    </script>
<? $base->endOfBody = lpTemplate::endBlock(); ?>

    <section>
        <header>工单 #<?= $tk["id"];?></header>
        <p>
            <?= $tk["content"];?>
        </p>
    </section>

    <section>
        <header>回复 (<?= $replys->num();?>)</header>
        <? while($replys->read()): ?>
            <p>
                <?= $replys["content"];?>
            </p>
        <? endwhile; ?>
    </section>

    <section>
        <header>操作</header>
        <? if($tk["settings"]["status"] != "ticket.status.closed" && !$tk["settings"]["onlyclosebyadmin"]): ?>
            <button class="btn btn-danger" id="deleteTK">关闭工单</button>
            <hr/>
        <? endif;?>
        <? if($tk["settings"]["status"] != "ticket.status.closed"): ?>
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="content">回复内容</label>

                    <div class="controls">
                        <label class="radio">
                            <textarea id="content" name="content" rows="10"></textarea><br/>
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">创建回复</button>
                </div>
            </form>
        <? endif;?>
    </section>

<? $base->output(); ?>