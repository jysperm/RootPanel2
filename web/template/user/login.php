<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["contact", "form", "base", "login"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = l("base.login");
?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= l("login.view.isDontHaveAccount");?></header>
    <a href="/user/signup/" class="btn btn-success"><?= l("login.view.clickToSignup");?></a>
</section>
<section>
    <header><?= l("login.view.isForgetPasswd");?></header>
    <a href="#" class="btn btn-info reset-email" rel="popover-click"
       data-content='<?= l("login.popover.resetPasswdEMail", c("AdminsEmail")); ?>'
       data-original-title="<?= l("login.view.forgetPasswd.email"); ?>"><?= l("login.view.forgetPasswd.email");?></a><br/>
    <a href="#" class="btn btn-info reset-qq" rel="popover-click"
       data-content='<?= l("login.popover.resetPasswdQQ", l("contact.qqButton")); ?>'
       data-original-title="<?= l("login.view.forgetPasswd.qq"); ?>"> <?= l("login.view.forgetPasswd.qq");?></a>
</section>
<? $base['sidebar'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    a[class*=btn] {
        width: 85px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<?php lpTemplate::beginBlock(); ?>
<script type="text/javascript">
    $(".reset-qq").click(function () {
        $(".reset-email").popover('hide');
    });
    $(".reset-email").click(function () {
        $(".reset-qq").popover('hide');
    });
</script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= l("base.login");?></header>
    <form class="form-horizontal" id="form" method="post">
        <div id="errorTips" class="alert alert-error<?= $this["errorMsg"] ? "" : " hide"; ?>">
            <header><?= l("form.error");?></header>
            <span id="errorBody"><?= $this["errorMsg"];?></span>
        </div>
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="uname"><?= l("login.account");?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="uname" name="uname"
                           value="<?= $this["uname"] ?: rpAuth::uname(); ?>" required="required"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="passwd"><?= l("login.passwd");?></label>

                <div class="controls">
                    <input type="password" class="input-xlarge" id="passwd" name="passwd" required="required"/>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"><?= l("base.login");?></button>
            </div>
        </fieldset>
    </form>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
