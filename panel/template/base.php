<?php

global $lpApp, $rpCfg;

?>
<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <title><?= isset($title) ? "{$title} | RP主机，技术宅的虚拟主机" : "RP主机，技术宅的虚拟主机";?></title>
      <?= isset($header)?$header:"";?>
    <link rel="shortcut icon" type="image/x-icon" href="/style/icon.png" />
    <link href='/LightPHP/lp-style/bootstrap-2.2.2/css/bootstrap.css' rel='stylesheet' type='text/css' />
    <link href='/LightPHP/lp-style/bootstrap-2.2.2/css/bootstrap-responsive.css' rel='stylesheet' type='text/css' />
    <link href="/style/global.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
      <?= isset($css)?$css:"";?>
    </style>
  </head>
  <body data-spy="scroll" data-target=".sidenav-bar" screen_capture_injected="true" class="well">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/"><?= $rpCfg["NodeName"];?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="/pay/"><i class="icon-shopping-cart icon-white"></i>购买</a></li>
              <li><a href="/public/manual/">用户手册</a></li>
              <li><a href="/public/review/">客户评价</a></li>
              <li><a href="/public/sites/">站点展示</a></li>
              <li><a href="http://rp-bbs.jybox.net">用户论坛</a></li>
            </ul>
            <ul class="nav pull-right">
              <? if($lpApp->auth()->login()): ?>
                <li><a><?= $lpApp->auth()->getUName();?></a></li>
                <? if(true): ?>
                  <li><a href="/pay/free/"><i class="icon-gift icon-white"></i>申请试用</a></li>
                <? endif; ?>
                <li><a href="/panel/"><i class="icon-list-alt icon-white"></i>管理面板</a></li>
                <li><a href="/user/logout/"><i class="icon-off icon-white"></i>注销</a></li>
              <? else: ?>
                <li><a href="/user/signup/"><i class="icon-edit icon-white"></i>注册</a></li>
                <li><a href="/user/login/"><i class="icon-user icon-white"></i>登录</a></li>
              <? endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row-fluid">
        <? if(isset($sidenav)): ?>
          <div class="span3 sidenav-bar">
            <ul data-spy="affix" class="nav nav-list sidenav">
              <?= $sidenav;?>
            </ul>
          </div>
        <? endif; ?>
        <div class="<?= !isset($sidebar) && !isset($sidenav) ? "span12" : "span9";?>">
          <?= $lpContents;?>
        </div>
        <? if(isset($sidebar)): ?>
          <div class="span3 sidebar">
            <?= $sidebar;?>
          </div>
        <? endif; ?>
      </div>
    </div>
    <script type='text/javascript' src='/LightPHP/lp-style/jquery-1.9.1/jquery.js'></script>
    <script type='text/javascript' src='/LightPHP/lp-style/bootstrap-2.2.2/js/bootstrap.js'></script>
	<script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
    <script type="text/javascript">
      $("a[rel=tooltip]").tooltip({trigger:"hover", html:true, placement:"top"});
      $("a[rel=popover]").popover({trigger:"hover", html:true, placement:"top"});
      $("a[rel=popover-click]").popover({html:true, placement:"top"}).show();
      $('a[href=#]').click(function (e) {
        e.preventDefault()
      })
      <?= isset($js)?$js:"";?>
    </script>
    <!--[if lte IE 8]>
      <script type='text/javascript' src='/style/kill-ie6.js'></script>
    <![endif]-->
    <?= isset($endOfBody)?$endOfBody:"";?>
  </body>
</html>

