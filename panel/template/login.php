<?php if(!isset($lpInTemplate)) die();

$tmp=new lpTemplate;

$a["title"]="登录";

lpBeginBlock();?>

<div class="box well">
    <header>还没有帐号？</header>
    <a href="/signup/" class="btn btn-success">点击这里注册</a>
</div>

<?php
$a["sidebar"]=lpEndBlock();

?>
<div class="box well">
  <header>登录</header>
  <form class="form-horizontal" id="form" method="post">
    <div id="errorTips" class="alert alert-error<?= isset($errorMsg)?"":" hide";?>">
      <header>错误</header> <span id="errorBody"><?= isset($errorMsg)?$errorMsg:"";?></span>
    </div>
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="uname">帐号</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="uname" name="uname" value="<?= isset($uname)?$uname:lpAuth::getUName();?>" required="required" />
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
</div>

<?php

$tmp->parse("template/base.php",$a);

?>
