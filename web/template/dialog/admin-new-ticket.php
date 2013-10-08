<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["ticket"]);

?>

<form class="website-form">
    <div class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="users"><?= l("ticket.admin.objUser");?></label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="users" name="users" required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title"><?= l("ticket.list.title");?></label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="title" name="title" required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&raquo;</label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach(l("ticket.types.long") as $k => $v): ?>
                            <option value="<?= $k; ?>" <?= $k == l("ticket.types.default") ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
                        <? endforeach; ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="onlyclosebyadmin"><i class="icon-check"></i></label>

            <div class="controls">
                <label class="radio">
                    <button id="onlyclosebyadmin" name="onlyclosebyadmin" type="button" class="btn" data-toggle="button">
                        <?= l("ticket.admin.closeOnlyByAdmin");?>
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="content"><?= l("ticket.create.content");?></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="content" name="content" rows="6"></textarea>
                </label>
            </div>
        </div>
    </div>
</form>