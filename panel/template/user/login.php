<?php

global $rpROOT, $rpCfg, $msg;

$base = new lpTemplate("{$rpROOT}/template/base.php");

$base->title = "登录";
?>

<? lpTemplate::beginBlock();?>
<section>
  <header>还没有帐号？</header>
  <a href="/user/signup/" class="btn btn-success">点击这里注册</a>
</section>
<section>
  <header>忘记密码？</header>
  <a href="#" class="btn btn-info reset-email" rel="popover-click" data-content='<?= $msg['resetPasswdEMail'];?>' data-original-title="通过邮件找回">通过邮件找回</a><br />
  <a href="#" class="btn btn-info reset-qq" rel="popover-click" data-content='<?= $msg['resetPasswdQQ'];?>' data-original-title="通过QQ找回"> 通过QQ找回</a>
</section>
<? $base->sidebar=lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
<style type="text/css">
  a[class*=btn] {
    width: 85px;
  }
</style>
<? $base->header = lpTemplate::endBlock();?>

<?php lpTemplate::beginBlock();?>
<script type="text/javascript">
  $(".reset-qq").click(function(){
    $(".reset-email").popover('hide');
  });
  $(".reset-email").click(function(){
    $(".reset-qq").popover('hide');
  });
</script>
<? $base->endOfBody=lpTemplate::endBlock();?>

<section>
  <header>登录</header>
  <form class="form-horizontal" id="form" method="post">
    <div id="errorTips" class="alert alert-error<?= isset($errorMsg)?"":" hide";?>">
      <header>错误</header>
      <span id="errorBody"><?= isset($errorMsg)?$errorMsg:"";?></span>
    </div>
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="uname">帐号</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="uname" name="uname" value="<?= isset($uname) ? $uname : rpAuth::uname();?>" required="required" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passwd">密码</label>
        <div class="controls">
          <input type="password" class="input-xlarge" id="passwd" name="passwd" required="required" />
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-large">登录</button>
      </div>
    </fieldset>
  </form>
</section>

<? $base->output();?>
