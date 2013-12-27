<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["form", "base", "contact", "signup"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = l("base.signup");
?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= l("signup.view.isHasAccount"); ?></header>
    <a href="/user/login/" class="btn btn-success"><?= l("signup.view.clickToLogin"); ?></a>
</section>
<section>
    <header><?= l("contact.service"); ?></header>
    <ul class="nav-list">
        <li><?= l("contact.email"); ?> <?= c("AdminsEmail"); ?></li>
        <?= l("contact.list"); ?>
    </ul>
</section>
<? $base['sidebar'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    input[type=checkbox] {
        vertical-align: middle;
        margin-top: -2px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form").submit(function () {
            $("#errorTips").hide();
            if ($("#isShowPasswd").hasClass("active"))
                $("#passwd").val($("#passwdtext").val());
        });
    });
    // 明文密文切换
    $(function () {
        $("#isShowPasswd").click(function () {
            // t; 目标input, s: 源input
            var t = !$("#isShowPasswd").hasClass("active") ? "#passwdtext" : "#passwd";
            var s = t == "#passwdtext" ? "#passwd" : "#passwdtext";
            $(t).show().attr("required", "required").val($(s).val()).focus();
            $(s).hide().removeAttr("required");
        })
    });
</script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= l("base.signup"); ?> <span
            class="text-small-per50 not-bold"><?= l("signup.view.signingNow"); ?><?= c("NodeName"); ?></span>
    </header>
    <form class="form-horizontal" id="form" method="post">
        <div id="errorTips" class="alert alert-error<?= $this["errorMsg"] ? "" : " hide"; ?>">
            <header><?= l("form.error"); ?></header>
            <span id="errorBody"><?= $this["errorMsg"]; ?></span>
        </div>
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="uname"><?= l("signup.account"); ?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="uname" name="uname"
                           value="<?= isset($uname) ? $uname : ""; ?>" required="required"/>

                    <p class="help-block"><?= l("signup.view.accountTips"); ?></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email"><?= l("signup.email"); ?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="email" name="email"
                           value="<?= isset($email) ? $email : ""; ?>" required="required"/>

                    <p class="help-block"><?= l("signup.view.emailTips"); ?></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="passwdtext"><?= l("signup.passwd"); ?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="passwdtext" name="passwdtext" required="required"/>
                    <input type="password" class="input-xlarge hide" id="passwd" name="passwd"/>
                    <button id="isShowPasswd" type="button" class="btn active"
                            data-toggle="button"><?= l("signup.view.isRaw"); ?></button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="qq"><?= l("signup.view.qq"); ?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="qq" name="qq" value="<?= isset($qq) ? $qq : ""; ?>"/>

                    <p class="help-block"><?= l("signup.view.qqTips"); ?></p>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"><?= l("base.signup"); ?></button>
            </div>
        </fieldset>
    </form>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
