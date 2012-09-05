<?php

require_once("./LightPHP/lp-load.php");
require_once("./config.php");

?>

<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <title>RP主机，技术宅的虚拟主机</title>
    <meta name="keywords" content="神马终端,RP,RP主机,低价,月付,终端,主机,虚拟主机,vps,网站,建站,php,linode,日本,linux,美国,免备案,python,代理,pptp,c++,python,ssh" />
    <meta name="description" content="RP主机" />
    <?= lpTools::linkTo("bootstrap",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-responsive",NULL,false); ?>
    <?= lpTools::linkTo("lp-css"); ?>
    <link href="/global.css" rel="stylesheet" type="text/css" />
  </head>
  <body data-spy="scroll" data-target="#rp-sidebar" screen_capture_injected="true">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/"></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="/">主页</a></li>
              <li><a href="/">付款方式</a></li>
              <li><a href="/">用户手册</a></li>
              <li><a href="/">客服支持</a></li>
              <li><a href="/">公告</a></li>
            </ul>
            <ul class="nav pull-right">
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="main" class="container">
      <div class="row">
        <div id="rp-sidebar" class="span3">
          <ul class="nav nav-list sidenav">
            <li><a href="#what-is-rphost"><i class="icon-chevron-right"></i> RP主机是什么</a></li>
            <li><a href="#what-can-it-do"><i class="icon-chevron-right"></i> RP主机能干什么</a></li>
            <li><a href="#try-and-by"><i class="icon-chevron-right"></i> 试用和购买</a></li>
            <li><a href="#resource"><i class="icon-chevron-right"></i> 资源参数</a></li>
            <li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
            <li><a href="#agreement"><i class="icon-chevron-right"></i> 政策和约定</a></li>
          </ul>
        </div>
      
        <div class="span9">
          <section id="what-is-rphost">
            <div class="page-header">
              <h1>RP主机是什么</h1>
            </div>
            <p class="lead">
              RP主机是一款为技术宅(Geek)提供的Linux虚拟主机.<br />
              和大多市面上的卖的虚拟主机相比，RP主机更加自由，你几乎可以在上面搭建所有类型的服务器，事实上，这相当于合租VPS了.<br />
              而价格又不高，适合搭建个人博客等小规模应用，适合喜欢折腾新鲜技术的技术宅.
            </p>
            <p class="lead">
              RP主机实际上就是一台划分了用户的Linux服务器，每个用户都可以干自己想做的事情.<br />
              当然，会有以root权限运行的监控程序限制你的资源使用，以免影响到其他用户.<br />
              为了能够使效率最大化，我们将最常用的一些服务(例如Apache、MySQL等)独立出来，以root权限运行，大家共同使用。而不是每个人都单独运行一份.
            </p>
          </section>
          <section id="what-can-it-do">
            <div class="page-header">
              <h1>RP主机能干什么</h1>
            </div>
            <p class="lead">
              你得到的是一个拥有极大权限的linux用户，你可以
              <ul>
                <li>建立网站，可以建立多个网站，绑定多个域名，无需备案</li>
                <li>使用PHP、Python(WSGI)、CGI建立动态站点</li>
                <li>访问MySQL、Mongodb、SQLite数据库</li>
                <li>配置反向代理、SSL版网站</li>
                <li>在终端运行Python、Ruby、Perl、C/C++程序，并且可以监听端口来进行Socket通讯</li>
                <li>使用PPTP VPN或SSH代理</li>
              </ul>
            </p>
          </section>
          <section id="try-and-by">
            <div class="page-header">
              <h1>试用和购买</h1>
            </div>
            <div class="row-fluid">
              <div class="span4">
                <h2>试用版</h2>
                <p class="h90">所有人都可以申请一个月的试用，需要填写100字的申请，人工审核(可重复申请)。试用版有较为严格的资源限制.</p>
                <p>
                  <a class="btn btn-success" href="assets/bootstrap.zip">1. 注册帐号</a> 
                  <a class="btn btn-success" href="assets/bootstrap.zip">2. 填写申请</a>
                </p>
              </div>
              <div class="span4">
                <h2>标准版</h2>
                <p class="h90">每月8元，每季度19元.</p>
                <p>
                  <a class="btn btn-success" href="assets/bootstrap.zip">1. 注册帐号</a> 
                  <a class="btn btn-success" href="assets/bootstrap.zip">2. 去淘宝付费</a>
                </p>
              </div>
              <div class="span4">
                <h2>额外技术支持版</h2>
                <p class="h90">每月15元，每季度35元.该版本的资源和标准版并无区别，但提供随叫随到的技术支持，帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务.</p>
                <p>
                  <a class="btn btn-success" href="assets/bootstrap.zip">1. 注册帐号</a> 
                  <a class="btn btn-success" href="assets/bootstrap.zip">2. 去淘宝付费</a>
                </p>
              </div>
            </div>
            <hr />
            <p class="lead">
              我们通过淘宝销售，出现质量问题以直接通过淘宝的流程进行维权。我们支持随时退款，按照剩余天数(加收10%手续费)退款.
            </p>
          </section>
          <section id="resource">
            <div class="page-header">
              <h1>资源参数</h1>
            </div>
            <p class="lead">
              <ul>
                <li>最小物理内存保证：20M</li>
                <li>最小内存保证：40M</li>
                <li>最小CPU保证：2%</li>
                <li>硬盘限制：500M</li>
                <li>流量限制(按月)：15G</li>
              </ul>
            </p>
            <p class="lead">
              最小保证即任何情况下都可以保证这么多的资源，如果服务器还剩余资源，则所有需要资源的账户均分剩余资源.<br />
              例如服务器剩余100M内存，有两个用户需要更多内存，则每人分得50M额外内存.<br />
              <br />
              注意：你运行的一切服务，都在以上的限制之中，包括但不限于自动备份、脚本、终端程序、PPTP、数据库.
            </p>
          </section>
        </div>
      </div>
    </div>
    <?= lpTools::linkTo("jquery",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-js",NULL,false); ?>
  </body>
</html>

