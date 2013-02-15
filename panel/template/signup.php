<?php

global $rpROOT, $rpCfg, $rpM;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title = "注册";
?>

<? lpTemplate::beginBlock();?>
<section>
  <header>已有帐号？</header>
  <a href="/user/login/" class="btn btn-success">点击这里登录</a>
</section>
<section>
  <header>咨询</header>
  <ul class="nav-list">
    <li>邮件 <?= array_values($rpCfg["Admins"])[0]["email"];?></li>
    <?= $rpM["contact"];?>
  </ul>
</section>
<? $tmp->sidebar=lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
  input[type=checkbox] {
    vertical-align: middle;
    margin-top: -2px;
  }
<? $tmp->css = lpTemplate::endBlock();?>

<?php lpTemplate::beginBlock();?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#form").submit(function()
    {
      $("#errorTips").hide();
      if($("#isShowPasswd").hasClass("active"))
        $("#passwd").val($("#passwdtext").val());
    });
  });
  // 明文密文切换
  $(function(){
    $("#isShowPasswd").click(function(){
      // t; 目标input, s: 源input
      t = !$("#isShowPasswd").hasClass("active") ? "#passwdtext" : "#passwd";
      s = t == "#passwdtext" ? "#passwd" : "#passwdtext";
      $(t).show().attr("required", "required").val($(s).val()).focus();
      $(s).hide().removeAttr("required");
    })
  });
</script>
<? $tmp->endOfBody = lpTemplate::endBlock();?>

<section>
  <header>注册 <span class="text-small-per50 not-bold">你正在注册的是：<?= $rpCfg["NodeName"];?></span></header>
  <form class="form-horizontal" id="form" method="post">
    <div id="errorTips" class="alert alert-error<?= isset($errorMsg)?"":" hide";?>">
      <header>错误</header>
      <span id="errorBody"><?= isset($errorMsg)?$errorMsg:"";?></span>
    </div>
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="uname">帐号</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="uname" name="uname" value="<?= isset($uname)?$uname:"";?>" required="required" />
          <p class="help-block">你可以使用英文、数字、下划线作为帐号,第一个字符必须为英文字母</p>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">邮箱</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="email" name="email" value="<?= isset($email)?$email:"";?>" required="required" />
          <p class="help-block">邮箱是与你联系的重要途径，请务必使用正确的邮箱，并经常检查邮件</p>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passwdtext">密码</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="passwdtext" name="passwdtext" required="required"  />
          <input type="password" class="input-xlarge hide" id="passwd" name="passwd" />
          <button id="isShowPasswd" type="button" class="btn active" data-toggle="button">明文</button>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="qq">QQ</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="qq" name="qq" value="<?= isset($qq)?$qq:"";?>" />
          <p class="help-block">RP主机的QQ客服将会依据该项辨别你的身份，可以留空</p>
        </div>
      </div>
      <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-large">注册</button>
      </div>
    </fieldset>
  </form>
</section>

<? $tmp->output();?>
