<?php

global $rpROOT, $rpCfg, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");

$base['title'] = $rpL["global.signup"];
?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= $rpL["signup.view.isHasAccount"];?></header>
    <a href="/user/login/" class="btn btn-success"><?= $rpL["signup.view.clickToLogin"];?></a>
</section>
<section>
    <header><?= $rpL["signup.view.service"];?></header>
    <ul class="nav-list">
        <li><?= $rpL["global.email"];?> admins@rpvhost.net</li>
        <?= $rpL["contact.list"];?>
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

<?php lpTemplate::beginBlock(); ?>
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

<section>
    <header><?= $rpL["global.signup"];?> <span
            class="text-small-per50 not-bold"><?= $rpL["signup.view.signingNow"];?><?= $rpCfg["NodeName"];?></span>
    </header>
    <form class="form-horizontal" id="form" method="post">
        <div id="errorTips" class="alert alert-error<?= isset($errorMsg) ? "" : " hide"; ?>">
            <header><?= $rpL["global.error"];?></header>
            <span id="errorBody"><?= isset($errorMsg) ? $errorMsg : "";?></span>
        </div>
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="uname"><?= $rpL["global.account"];?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="uname" name="uname"
                           value="<?= isset($uname) ? $uname : ""; ?>" required="required"/>

                    <p class="help-block"><?= $rpL["signup.view.accountTips"];?></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email"><?= $rpL["global.email"];?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="email" name="email"
                           value="<?= isset($email) ? $email : ""; ?>" required="required"/>

                    <p class="help-block"><?= $rpL["signup.view.emailTips"];?></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="passwdtext"><?= $rpL["global.passwd"];?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="passwdtext" name="passwdtext" required="required"/>
                    <input type="password" class="input-xlarge hide" id="passwd" name="passwd"/>
                    <button id="isShowPasswd" type="button" class="btn active"
                            data-toggle="button"><?= $rpL["signup.view.isRaw"];?></button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="qq"><?= $rpL["signup.view.qq"];?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="qq" name="qq" value="<?= isset($qq) ? $qq : ""; ?>"/>

                    <p class="help-block"><?= $rpL["signup.view.qqTips"];?></p>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"><?= $rpL["global.signup"];?></button>
            </div>
        </fieldset>
    </form>
</section>

<? $base->output(); ?>
