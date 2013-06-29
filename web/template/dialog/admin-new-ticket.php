<?php

global $rpL;
lpLocale::i()->load(["ticket"]);

?>

<form class="website-form">
    <div class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="users">目标用户</label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="users" name="users" required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title">标题</label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="title" name="title" required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&raquo;</label>

            <div class="controls">
                <label class="radio">
                    <select id="type" name="type">
                        <? foreach($rpL["ticket.types.long"] as $k => $v): ?>
                            <option value="<?= $k; ?>" <?= $k == "miao" ? 'selected="selected"' : ""; ?>><?= $v; ?></option>
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
                        只允许管理员关闭
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="content">内容</label>

            <div class="controls">
                <label class="radio">
                    <textarea id="content" name="content" rows="6"></textarea>
                </label>
            </div>
        </div>
    </div>
</form>