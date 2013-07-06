<?php
$base = new lpTemplate(rpROOT . "/template/base.php");
$page = lpDividePage::fromGET();
$base['title'] = $titile = "工单 #{$page}";

$rows = rpTicketModel::count(["uname" => rpAuth::uname()]);
$dPage = new lpDividePage($rows, $page, $rpCfg["TKPerPage"]);

if(isset($_GET["template"]))
    $template = in_array($_GET["template"], array_keys($rpL["ticket.template"])) ? $_GET["template"] : null;
else
    $template = null;
?>

<? lpTemplate::beginBlock(); ?>
<? if(!$template): ?>
    <li class="active"><a href="#section-list"><i class="icon-chevron-right"></i> 工单列表 #<?= $page; ?></a></li>
    <li><a href="#section-new"><i class="icon-chevron-right"></i> 创建工单</a></li>
<? else: ?>
    <li class="active"><a href="#section-new"><i class="icon-chevron-right"></i> 创建工单</a></li>
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

<? if(!$template): ?>
    <section id="section-list">
        <header>工单列表 #<?= $page; ?></header>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>ID</th>
                <th>类型</th>
                <th>状态</th>
                <th>标题</th>
                <th>回复</th>
            </tr>
            </thead>
            <tbody>
            <? foreach(rpTicketModel::select(["uname" => rpAuth::uname()], ["sort" => ["lastchange", false], "limit" => $rpCfg["TKPerPage"], "skip" => $dPage->getPos()]) as $tk): ?>
                <tr>
                    <td><?= $tk["id"]; ?></td>
                    <td><?= $rpL["ticket.types"][$tk["type"]]; ?></td>
                    <td><?= $rpL[$tk["status"]]; ?></td>
                    <td><a href="/ticket/view/<?= $tk["id"]; ?>/"><?= $tk["title"]; ?></a></td>
                    <td>
                        <?= rpTicketReplyModel::count(["replyto" => $tk["id"]]);?> 个回复 | <?= $tk["lastreply"];?> 于
                        <span title="<?= gmdate("Y.m.d H:i:s", $tk["lastchange"]); ?>"><?= rpTools::niceTime($tk["lastchange"]); ?></span>
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
                        return "<li><a href='/ticket/list/?p={$page}'>{$page}</a></li>";
                }); ?>
            </ul>
        </div>
    </section>
<? endif; ?>

<section id="section-new">
    <header>创建工单</header>
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="title">标题</label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="title" name="title"
                           required="required" <?= $template ? "value='" . $rpL["ticket.template"][$template]["title"] . "'" : ""; ?> />
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type">类型</label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach($rpL["ticket.types.long"] as $k => $v): ?>
                            <? if(!$template): ?>
                                <option
                                    value="<?= $k; ?>" <?= $k == "miao" ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                                <? else: ?>
                                <option
                                    value="<?= $k; ?>" <?= $k == $rpL["ticket.template"][$template]["type"] ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                            <? endif; ?>
                        <? endforeach; ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="content">内容</label>

            <div class="controls">
                <label class="radio">
                    <textarea id="content" name="content"
                              rows="10"><?= $template ? $rpL["ticket.template"][$template]["content"] : ""; ?></textarea><br/>
                </label>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">创建</button>
        </div>
    </form>
</section>

<? $base->output(); ?>
