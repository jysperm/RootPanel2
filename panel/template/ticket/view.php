<?php

global $rpROOT, $rpL, $rpCfg;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base['title'] = $titile = "工单 #{$tk["id"]}";

?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#content"><i class="icon-chevron-right"></i> 工单 #<?= $tk["id"]; ?></a></li>
    <li><a href="#replys"><i class="icon-chevron-right"></i> 回复</a></li>
    <li><a href="#operation"><i class="icon-chevron-right"></i> 操作</a></li>
    <li><a href="/ticket/"><i class="icon-arrow-left"></i> 返回工单</a></li>
    <li><a href="/panel/"><i class="icon-arrow-left"></i> 返回面板</a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <style type="text/css">
        textarea {
            width: 530px;
        }

        .box hr, #content hr {
            margin: 1px;
        }
    </style>
<? $base['header'] = lpTemplate::endBlock(); ?>

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
        $($("#deleteTK").click(function(){
            $.post("/ticket/close/<?= $tk["id"];?>/", {}, function (data) {
                if (data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
        }));
        $($("#finishTK").click(function(){
            $.post("/ticket/finish/<?= $tk["id"];?>/", {}, function (data) {
                if (data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
        }));
    </script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<section id="content">
    <header><?= $tk["title"]; ?></header>
    <p>
        <?= $tk["content"]; ?>
    </p>
    <hr />
    <span class="label">
        <span title="<?= gmdate("Y.m.d H:i:s", $tk["time"]); ?>"><?= rpTools::niceTime($tk["time"]); ?></span>
        | <?= $tk["uname"]; ?>
    </span>
</section>

<section id="replys">
    <header>回复 (<?= rpTicketReplyModel::count(["replyto" => $tk["id"]]); ?>)</header>
    <? foreach(rpTicketReplyModel::select(["replyto" => $tk["id"]]) as $reply): ?>
        <div class="box">
            <?= $reply["content"]; ?>
            <hr />
            <span class="label">
                <span
                    title="<?= gmdate("Y.m.d H:i:s", $reply["time"]); ?>"><?= rpTools::niceTime($reply["time"]); ?></span>
                | <?= $reply["uname"]; ?>
            </span>
        </div>
    <? endforeach; ?>
</section>

<section id="operation">
    <header>操作</header>
    <? if($tk["status"] != rpTicketModel::CLOSED && (!$tk["onlyclosebyadmin"] || lpFactory::get("rpUserModel")->isAdmin())): ?>
        <button class="btn btn-danger" id="deleteTK">关闭工单</button>
    <? endif; ?>
    <? if(lpFactory::get("rpUserModel")->isAdmin() && $tk["status"] == rpTicketModel::HODE): ?>
        <button class="btn btn-success" id="finishTK">标记完成</button>
    <? endif; ?>
    <hr/>
    <? if($tk["status"] != "ticket.status.closed"): ?>
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
    <? else: ?>
        <div>
            工单已被关闭
        </div>
    <? endif; ?>
</section>

<? $base->output(); ?>