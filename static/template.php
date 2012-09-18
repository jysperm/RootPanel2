<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <title><?= $title;?></title>
    <?= $header;?>
    <?= lpTools::linkTo("bootstrap",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-responsive",NULL,false); ?>
    <?= lpTools::linkTo("lp-css"); ?>
    <link href="/global.css" rel="stylesheet" type="text/css" />
  </head>
  <body data-spy="scroll" data-target="#rp-sidebar" screen_capture_injected="true">
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
              <li><a href="/">主页</a></li>
              <li><a href="/pay/">付款方式</a></li>
              <li><a href="/manual/">用户手册</a></li>
              <li><a href="/service/">客服支持</a></li>
              <li><a href="/news/">公告</a></li>
            </ul>
            <ul class="nav pull-right">
              <li><a href="http://<?= $panelDomain;?>/">登录到管理面板</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="main" class="container">
      <div class="row-fluid">
        <div id="rp-sidebar" class="span3">
          <ul data-spy="affix" class="nav nav-list sidenav">
            <?= $rpSidebar;?>
          </ul>
        </div>
      
        <div class="span9">
          <?= $lpContents;?>
        </div>
      </div>
    </div>
    <?= lpTools::linkTo("jquery",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-js",NULL,false); ?>
    <?= $endOfBody;?>
  </body>
</html>

