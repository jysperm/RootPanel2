<?php if(!isset($lpInTemplate)) die();

global $rpROOT;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title="注册";

lpTemplate::beginBlock();?>

<div class="box well">
    <header>已有帐号？</header>
    <a href="/login/" class="btn btn-success">点击这里登录</a>
</div>

<?php
$tmp->sidebar=lpTemplate::endBlock();

?>
<div class="box well">
  <header>注册</header>
  <form class="form-horizontal" id="form" method="post">
    <div id="errorTips" class="alert alert-error<?= isset($errorMsg)?"":" hide";?>">
      <header>错误</header> <span id="errorBody"><?= isset($errorMsg)?$errorMsg:"";?></span>
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
          <p class="help-block">邮箱是与你联系的主要途径，请务必使用正确的邮箱，并经常检查邮件</p>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passwd">密码</label>
        <div class="controls">
          <input type="password" class="input-xlarge" id="passwd" name="passwd" required="required" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passwd2">重复</label>
        <div class="controls">
          <input type="password" class="input-xlarge" id="passwd2" name="passwd2" required="required" />
        </div>
      </div>
      <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-large">注册</button>
      </div>
    </fieldset>
  </form>
</div>

<?php lpTemplate::beginBlock();?>

<script type="text/javascript">

$(document).ready(function(){
  $("#form").submit(function()
  {
  $("#errorTips").hide();
    if($("#passwd").val()!=$("#passwd2").val())
    {
      $("#errorBody").html("请输入两次同样的密码");
      $("#errorTips").show();
      return false;
    }
  });
});

</script>

<?php 
$tmp->endOfBody=lpTemplate::endBlock();

$tmp->output();

?>
