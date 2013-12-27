<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["base", "ticket"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$page = lpDividePage::fromGET();

$base['title'] = l("ticket.title");

$rows = rpTicketModel::count(["uname" => rpAuth::uname()]);
$dPage = new lpDividePage($rows, $page, c("TKPerPage"));

if (!empty($_GET["template"]))
    $template = in_array($_GET["template"], array_keys(l("ticket.template"))) ? $_GET["template"] : null;

?>

<? lpTemplate::beginBlock(); ?>
<? if (empty($template)): ?>
    <li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> <?= l("ticket.ticketList", $page); ?>
        </a></li>
    <li><a href="#section-new"><i class="icon-chevron-right"></i> <?= l("ticket.create"); ?></a></li>
    <li><a href="/panel/"><i class="icon-arrow-left"></i> <?= l("ticket.nav.returnPanel"); ?></a></li>
<? else: ?>
    <li class="active"><a href="#section-new"><i class="icon-chevron-right"></i> <?= l("ticket.create"); ?></a>
    <li><a href="/panel/"><i class="icon-arrow-left"></i> <?= l("ticket.nav.returnPanel"); ?></a></li>
<? endif; ?>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    table {
        word-break: break-all;
    }

    textarea {
        width: 530px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript'>
    $($("form").submit(function () {
        $.post("/ticket/create/", $("form").serializeArray(), function (data) {
            if (data.status == "ok")
                window.location.href = "/ticket/list/";
            else
                alert(data.msg);
        }, "json");
        return false;
    }));
</script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<? if (empty($template)): ?>
    <section id="section-list">
        <header><?= l("ticket.ticketList", $page); ?></header>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th><?= l("ticket.list.id"); ?></th>
                <th><?= l("ticket.list.type"); ?></th>
                <th><?= l("ticket.list.status"); ?></th>
                <th><?= l("ticket.list.title"); ?></th>
                <th><?= l("ticket.list.reply"); ?></th>
            </tr>
            </thead>
            <tbody>
            <? foreach (rpTicketModel::select(["uname" => rpAuth::uname()], ["sort" => ["lastchange", false], "limit" => c("TKPerPage"), "skip" => $dPage->getPos()]) as $tk): ?>
                <tr>
                    <td><?= $tk["id"]; ?></td>
                    <td><?= l("ticket.types")[$tk["type"]]; ?></td>
                    <td><?= l($tk["status"]); ?></td>
                    <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                    <td>
                        <?=
                        l("ticket.replyBy", rpTicketReplyModel::count(["replyto" => $tk["id"]]), $tk["lastreply"],
                            "<span title='" . gmdate(l("base.fullTime"), $tk["lastchange"]) . "'>" . rpTools::niceTime($tk["lastchange"]) . "</span>");?>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <div class="pagination pagination-centered">
            <ul>
                <?=
                $dPage->getOutput(function ($page, $curPage) {
                    if ($curPage == $page || $page == lpDividePage::splitter)
                        return "<li class='active'><a href='#'>{$page}</a></li>";
                    else
                        return "<li><a href='/ticket/list/?p={$page}'>{$page}</a></li>";
                }); ?>
            </ul>
        </div>
    </section>
<? endif; ?>

<section id="section-new">
    <header><?= l("ticket.create"); ?></header>
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="title"><?= l("ticket.list.title"); ?></label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="title" name="title"
                           required="required" <?= !empty($template) ? "value='" . l("ticket.template")[$template]["title"] . "'" : ""; ?> />
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type"><?= l("ticket.list.type"); ?></label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach (l("ticket.types.long") as $k => $v): ?>
                            <? if (empty($template)): ?>
                                <option
                                    value="<?= $k; ?>" <?= $k == l("ticket.types.default") ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                            <? else: ?>
                                <option
                                    value="<?= $k; ?>" <?= $k == l("ticket.template")[$template]["type"] ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                            <? endif; ?>
                        <? endforeach; ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="content"><?= l("ticket.create.content"); ?></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="content" name="content"
                              rows="10"><?= !empty($template) ? l("ticket.template")[$template]["content"] : ""; ?></textarea><br/>
                </label>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large"><?= l("ticket.create.create"); ?></button>
        </div>
    </form>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
