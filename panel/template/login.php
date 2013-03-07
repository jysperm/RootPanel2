<?php

global $rpROOT, $rpCfg, $msg;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title = "登录";
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
<? $tmp->sidebar=lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
  a[class*=btn] {
    width: 85px;
  }
<? $tmp->css = lpTemplate::endBlock();?>

<?php lpTemplate::beginBlock();?>
<script type="text/javascript">
  $(".reset-qq").click(function(){
    $(".reset-email").popover('hide');
  });
  $(".reset-email").click(function(){
    $(".reset-qq").popover('hide');
  });
</script>
<? $tmp->endOfBody=lpTemplate::endBlock();?>

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

<? $tmp->output();?>
