<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/** @var lpLocale $rpL */
$rpL = f("lpLocale");

$rpL->load(["base", "login", "contact"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = $rpL["base.login"];
?>

<? lpTemplate::beginBlock(); ?>
<section>
    <header><?= $rpL["login.view.isDontHaveAccount"];?></header>
    <a href="/user/signup/" class="btn btn-success"><?= $rpL["login.view.clickToSignup"];?></a>
</section>
<section>
    <header><?= $rpL["login.view.isForgetPasswd"];?></header>
    <a href="#" class="btn btn-info reset-email" rel="popover-click"
       data-content='<?= sprintf(l("login.popover.resetPasswdEMail"), c("AdminsEmail")); ?>'
       data-original-title="<?= $rpL["login.view.forgetPasswd.email"]; ?>"><?= $rpL["login.view.forgetPasswd.email"];?></a><br/>
    <a href="#" class="btn btn-info reset-qq" rel="popover-click"
       data-content='<?= sprintf(l("login.popover.resetPasswdQQ"), l("contact.qqButton")); ?>'
       data-original-title="<?= $rpL["login.view.forgetPasswd.qq"]; ?>"> <?= $rpL["login.view.forgetPasswd.qq"];?></a>
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
    <header><?= $rpL["base.login"];?></header>
    <form class="form-horizontal" id="form" method="post">
        <div id="errorTips" class="alert alert-error<?= $this["errorMsg"] ? "" : " hide"; ?>">
            <header><?= $rpL["form.error"];?></header>
            <span id="errorBody"><?= $this["errorMsg"];?></span>
        </div>
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="uname"><?= $rpL["login.account"];?></label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="uname" name="uname"
                           value="<?= $this["uname"] ?: rpAuth::uname(); ?>" required="required"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="passwd"><?= $rpL["login.passwd"];?></label>

                <div class="controls">
                    <input type="password" class="input-xlarge" id="passwd" name="passwd" required="required"/>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"><?= $rpL["base.login"];?></button>
            </div>
        </fieldset>
    </form>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
