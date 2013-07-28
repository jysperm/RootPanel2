<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["base", "ticket"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$tk = $this["tk"];

$base['title'] = $titile = l("ticket.ticketList", $tk["id"]);

?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#content"><i class="icon-chevron-right"></i> <?= $titile; ?></a></li>
    <li><a href="#replys"><i class="icon-chevron-right"></i> <?= l("ticket.list.reply"); ?></a></li>
    <li><a href="#operation"><i class="icon-chevron-right"></i> <?= l("ticket.nav.opeator"); ?></a></li>
    <li><a href="/ticket/"><i class="icon-arrow-left"></i> <?= l("ticket.nav.returnList"); ?></a></li>
    <li><a href="/panel/"><i class="icon-arrow-left"></i> <?= l("ticket.nav.returnPanel"); ?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <style type="text/css">
        textarea {
            width: 530px;
        }
        .box hr, #content hr {
            margin: 1px;
        }
        section header {
            font-size: 28px;
        }
        section {
            line-height: 22px;
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

<? lpTemplate::beginBlock(); ?>
<section id="content">
    <header><?= rpTools::escapePlantText($tk["title"]); ?></header>
    <p>
        <?= rpTools::escapePlantText($tk["content"]); ?>
    </p>
    <hr />
    <span class="label">
        <span title="<?= gmdate(l("base.fullTime"), $tk["time"]); ?>"><?= rpTools::niceTime($tk["time"]); ?></span>
        | <?= $tk["uname"]; ?>
    </span>
</section>

<section id="replys">
    <header><?= l("ticket.list.reply"); ?> (<?= rpTicketReplyModel::count(["replyto" => $tk["id"]]); ?>)</header>
    <? foreach(rpTicketReplyModel::select(["replyto" => $tk["id"]]) as $reply): ?>
        <div class="box">
            <?= rpTools::escapePlantText($reply["content"]); ?>
            <hr />
            <span class="label">
                <span
                    title="<?= gmdate(l("base.fullTime"), $reply["time"]); ?>"><?= rpTools::niceTime($reply["time"]); ?></span>
                | <?= $reply["uname"]; ?>
            </span>
        </div>
    <? endforeach; ?>
</section>

<section id="operation">
    <header><?= l("ticket.nav.opeator"); ?></header>
    <? if($tk["status"] != rpTicketModel::CLOSED && (!$tk["onlyclosebyadmin"] || lpFactory::get("rpUserModel")->isAdmin())): ?>
        <button class="btn btn-danger" id="deleteTK"><?= l("ticket.opeator.close"); ?></button>
    <? endif; ?>
    <? if(lpFactory::get("rpUserModel")->isAdmin() && ($tk["status"] == rpTicketModel::HODE || $tk["status"] == rpTicketModel::OPEN)): ?>
        <button class="btn btn-success" id="finishTK"><?= l("ticket.opeator.finish"); ?></button>
    <? endif; ?>
    <hr/>
    <? if($tk["status"] != "ticket.status.closed"): ?>
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="content"><?= l("ticket.opeator.content"); ?></label>

                <div class="controls">
                    <label class="radio">
                        <textarea id="content" name="content" rows="10"></textarea><br/>
                    </label>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"><?= l("ticket.opeator.reply"); ?></button>
            </div>
        </form>
    <? else: ?>
        <div><?= l("ticket.opeator.closed"); ?></div>
    <? endif; ?>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>