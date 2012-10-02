<?php if(!isset($lpInTemplate)) die();

if(!isset($dontChangeTitle) || !$dontChangeTitle)
    $title .= " | RP主机，技术宅的虚拟主机";
    
if(lpAuth::login())
{
    $conn=new lpMySQL;
    $rs=$conn->select("user",array("uname"=>lpAuth::getUName()));
    $rs->read();
}

?>
<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <title><?= $title;?></title>
    <?= isset($header)?$header:"";?>
    <?= lpTools::linkTo("bootstrap",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-responsive",NULL,false); ?>
    <?= lpTools::linkTo("lp-css"); ?>
    <link href="/global.css" rel="stylesheet" type="text/css" />
  </head>
  <body data-spy="scroll" data-target="#rp-sidebar" screen_capture_injected="true" class="well">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">RP-HOST</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="/"><i class="icon-home icon-white"></i>主页</a></li>
              <li><a href="/pay/"><i class="icon-shopping-cart icon-white"></i>购买</a></li>
              <li><a href="/manual/">用户手册</a></li>
              <li><a href="/news/">公告</a></li>
            </ul>
            <ul class="nav pull-right">
              <? if(lpAuth::login()): ?>
                <li><a><?= lpAuth::getUName();?></a></li>
                <? if($rs->type=="no" || $rs->type=="free"): ?>
                  <li><a href="/request-free/"><i class="icon-gift icon-white"></i>申请试用</a></li>
                <? endif; ?>
                <li><a href="/panel/"><i class="icon-list-alt icon-white"></i>管理面板</a></li>
                <li><a href="/logout/"><i class="icon-off icon-white"></i>注销</a></li>
              <? else: ?>
                <li><a href="/signup/"><i class="icon-edit icon-white"></i>注册</a></li>
                <li><a href="/login/"><i class="icon-user icon-white"></i>登录</a></li>
              <? endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="<?= isset($mainClass)?$mainClass:"main";?>" class="container">
      <div class="row-fluid">
        <? if(isset($rpSidebar)): ?>
          <div id="rp-sidebar" class="span3">
            <ul data-spy="affix" class="nav nav-list sidenav">
              <?= $rpSidebar;?>
            </ul>
          </div>
        <? endif; ?>
        <div class="span9">
          <?= $lpContents;?>
        </div>
        <? if(isset($sidebar)): ?>
          <div class="span3">
              <?= $sidebar;?>
          </div>
        <? endif; ?>
      </div>
    </div>
    <?= lpTools::linkTo("jquery",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-js",NULL,false); ?>
    <?= isset($endOfBody)?$endOfBody:"";?>
  </body>
</html>

