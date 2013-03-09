<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

global $rpROOT, $rpCfg, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");

$msg["free"] = <<< HTML

CPU时间限制(按天)：500秒(相当于0.6%)<br />
最小内存保证：10M<br />
内存竞争系数：0.4(与付费用户竞争内存时的系数)<br />
硬盘限制：300M<br />
流量限制(按天)：300M<br />
流量限制(按月)：3G<br />

HTML;

$msg["evn"] = "RP主机提供了完整的Linux环境，即使RP主机默认不提供某语言的运行环境，你也可以通过Linux下安装软件的常规方式自行安装该语言环境.";

$msg["ext"] = "帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务.";

$msg["proxy"] = <<< HTML

<ul>
<li>Secure Shell</li>
<li>Virtual Private Network</li>
<li>(Point to Point Tunneling Protocol)</li>
<li>ShadowSocks</li>
</ul>

HTML;

$msg["site"] = <<< HTML

可以运行几乎所有常见的建站系统：<br />

<ul>
<li>WordPress 博客</li>
<li>PHPWind 论坛</li>
<li>Discuz! X 论坛</li>
<li>Typecho 博客</li>
<li>Drupal CMS</li>
<li>Anwsion 问答</li>
<li>MediaWiki 维基</li>
<li>ECShop 网店</li>
<li>写不下了...</li>
</ul>

HTML;

?>

<? lpTemplate::beginBlock();?>
    <meta name="keywords" content="神马终端,RP,RP主机,低价,月付,终端,主机,虚拟主机,vps,网站,建站,php,linode,日本,linux,美国,免备案,python,代理,pptp,c++,python,ssh" />
    <meta name="description" content="RP主机是一款为技术宅(Geek)提供的Linux虚拟主机, 实际上就是一台划分了用户的Linux服务器，每个用户都可以干自己想做的事情." />
<? $base->header = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
    <li class="active"><a href="#what-is-rphost"><i class="icon-chevron-right"></i> RP主机是什么</a></li>
    <li><a href="#what-can-it-do"><i class="icon-chevron-right"></i> RP主机能干什么</a></li>
    <li><a href="#try-and-buy"><i class="icon-chevron-right"></i> 试用和购买</a></li>
    <li><a href="#resource"><i class="icon-chevron-right"></i> 资源参数</a></li>
    <li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
    <li><a href="#agreement"><i class="icon-chevron-right"></i> 政策和约定</a></li>
<? $base->sidenav = lpTemplate::endBlock(); ?>

<section id="what-is-rphost">
  <header>RP主机是什么</header>
  <p>
    RP主机是一款为技术宅(Geek)提供的Linux虚拟主机.<br />
    和大多市面上的卖的虚拟主机相比，RP主机更加自由，你几乎可以在上面搭建所有类型的服务器，事实上，这相当于合租VPS了.<br />
    而价格又不高，适合搭建个人博客等小规模应用，适合喜欢折腾新鲜技术的技术宅.
  </p>
  <p>
    RP主机实际上就是一台划分了用户的Linux服务器，每个用户都可以干自己想做的事情.<br />
    当然，会有以root权限运行的监控程序限制你的资源使用，以免影响到其他用户.<br />
    为了能够使效率最大化，我们将最常用的一些服务(例如Apache、MySQL等)独立出来，以root权限运行，大家共同使用。而不是每个人都单独运行一份.
  </p>
</section>
<section id="what-can-it-do">
  <header>RP主机能干什么</header>
  <p>
    你得到的是一个拥有极大权限的linux用户，你可以
  </p>
  <ul>
    <li><a href="#" rel="popover" data-content="<?= $msg['site'];?>" data-original-title="建站系统">建立网站</a>，可以建立无限个网站，绑定无限个域名，无需备案</li>
    <li>使用PHP、Python、CGI等技术建立动态站点，RP主机支持<a href="#" rel="popover" data-content="<?= $msg['evn'];?>" data-original-title="环境支持">几乎全部</a>编程语言</li>
    <li>访问MySQL、Mongo、SQLite等各种数据库</li>
    <li>配置反向代理、SSL版网站</li>
    <li>在终端运行Python、Ruby、Node、Perl、C/C++程序，并且可以监听端口来进行Socket通讯</li>
    <li>使用<a href="#" rel="popover" data-content="<?= $msg['proxy'];?>" data-original-title="接入世界性互联网">多种技术</a>接入世界性互联网</li>
  </ul>
</section>
<section id="try-and-buy">
  <header>试用和购买</header>
  <div class="row-fluid products-show">
    <div class="span4">
      <header>试用版</header>
      <div class="description">
        所有人都可以申请一个月的试用，需要填写100字的申请，人工审核(可重复申请)。试用版有较为严格的
        <a href="#" rel="popover" data-content="<?= $msg['free'];?>" data-original-title="试用帐号限制">资源限制</a>
      </div>
      <p>
        <a class="btn btn-success" href="/user/signup/">1. 注册帐号</a>
        <a class="btn btn-success" href="/pay/free/">2. 填写申请</a>
      </p>
    </div>
    <div class="span4">
      <header>标准版</header>
      <div class="description">每月8元，每季度19元.</div>
      <p>
        <a class="btn btn-success" href="/user/signup/">1. 注册帐号</a>
        <a class="btn btn-success" href="/pay/">2. 淘宝付款</a>
      </p>
    </div>
    <div class="span4">
      <header>额外技术支持版</header>
      <div class="description">
        每月15元，每季度35元.该版本的资源和标准版并无区别，但提供随叫随到的
        <a href="#" rel="popover" data-content="<?= $msg['ext'];?>" data-original-title="技术支持">技术支持</a>.
      </div>
      <p>
        <a class="btn btn-success" href="/user/signup/">1. 注册帐号</a>
        <a class="btn btn-success" href="/pay/">2. 淘宝付款</a>
      </p>
    </div>
  </div>
  <hr />
  <p>
    我们通过淘宝销售，出现质量问题可以直接通过淘宝的流程进行维权。我们支持随时退款，按照剩余天数(加收10%手续费)退款.
  </p>
</section>
<section id="resource">
  <header>资源参数</header>
    <?php
    lpTemplate::outputFile("{$rpROOT}/template/node-list.php");
    ?>
  <p>
    注意：你运行的一切服务，都在以上的限制之中，包括但不限于网页、数据库、梯子、终端程序.
  </p>
</section>
<section id="service">
  <header>客服</header>
  <p>
    RP主机的客服主要以邮件的方式提供，你可以与客服沟通你在使用中遇到的任何问题，例如你需要某个运行库，但服务器没有安装等等.<br />
    `额外技术支持版`中提供随叫随到的技术支持，帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务.
    而标准版中，是否解答于服务器无关的问题(例如某个软件如何使用),视客服心情而定.
  </p>
  <p>
    <? $emails = []; ?>
    <? foreach($rpCfg["Admins"] as $adminID => $admin): ?>
      <? $adminInfo = "{$admin['description']}<br />QQ: {$admin['qq']}<br />E-mail: {$admin['email']}";?>
      <a class="admin" target="_blank" href="<?= $admin["url"];?>" rel="popover" data-content="<?= $adminInfo;?>" data-original-title="客服：<?= $admin["name"];?>">
        <img alt="<?= $admin["name"];?>" src="<?= rpTools::gravatarURL($admin["email"], 48);?>">
      </a>
      <? $emails[]= $admin["email"]; ?>
      <? $emails = array_merge($emails, $admin["otherEmails"]); ?>
    <? endforeach; ?>
  </p>
  <p>
    客服邮箱：
    <? foreach($emails as $email): ?>
      <code><i class="icon-envelope"></i><?= $email;?></code>
    <? endforeach; ?>
  </p>
  <ul class="left-tabs">
      <?= $rpL["contact.list"];?>
  </ul>
</section>

<? lpTemplate::outputFile("{$rpROOT}/locale/{$rpCfg['lang']}/template/agreement.php");?>

<? $base->output();?>