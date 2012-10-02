<?php

require_once("./LightPHP/lp-load.php");
require_once("./config.php");

$tmp = new lpTemplate;

$a["dontChangeTitle"] = true;
$a["title"] = "RP主机，技术宅的虚拟主机";

lpBeginBlock();?>

<meta name="keywords" content="神马终端,RP,RP主机,低价,月付,终端,主机,虚拟主机,vps,网站,建站,php,linode,日本,linux,美国,免备案,python,代理,pptp,c++,python,ssh" />
<meta name="description" content="RP主机" />

<?php
$a["header"]=lpEndBlock();

lpBeginBlock();?>

<li class="active"><a href="#what-is-rphost"><i class="icon-chevron-right"></i> RP主机是什么</a></li>
<li><a href="#what-can-it-do"><i class="icon-chevron-right"></i> RP主机能干什么</a></li>
<li><a href="#try-and-by"><i class="icon-chevron-right"></i> 试用和购买</a></li>
<li><a href="#resource"><i class="icon-chevron-right"></i> 资源参数</a></li>
<li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
<li><a href="#agreement"><i class="icon-chevron-right"></i> 政策和约定</a></li>

<?php
$a["rpSidebar"]=lpEndBlock();

lpBeginBlock();?>

<script type="text/javascript">
  $("a[rel=popover]")
  .popover({trigger:"hover"})
  .click(function(e) {
    e.preventDefault()
  });
</script>

<?php
$a["endOfBody"]=lpEndBlock();

?>

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
      <p class="h90">所有人都可以申请一个月的试用，需要填写100字的申请，人工审核(可重复申请)。试用版有较为严格的
      <a href="#" rel="popover" data-content="CPU时间限制(按天)：500秒(相当于0.6%)<br />最小内存保证：10M<br />内存竞争系数：0.4(与付费用户竞争内存时的系数)<br />硬盘限制：300M<br />流量限制(按天)：300M<br />流量限制(按月)：3G<br />" data-original-title="试用帐号限制">资源限制</a>
      </p>
      <p>
        <a class="btn btn-success" href="/signup/">1. 注册帐号</a> 
        <a class="btn btn-success" href="/request-free/">2. 填写申请</a>
      </p>
    </div>
    <div class="span4">
      <h2>标准版</h2>
      <p class="h90">每月8元，每季度19元.</p>
      <p>
        <a class="btn btn-success" href="/signup/">1. 注册帐号</a> 
        <a class="btn btn-success" href="/pay/">2. 通过淘宝付款</a>
      </p>
    </div>
    <div class="span4">
      <h2>额外技术支持版</h2>
      <p class="h90">每月15元，每季度35元.该版本的资源和标准版并无区别，但提供随叫随到的技术支持，帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务.</p>
      <p>
        <a class="btn btn-success" href="/signup/">1. 注册帐号</a> 
        <a class="btn btn-success" href="/pay/">2. 通过淘宝付款</a>
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
<section id="service">
  <div class="page-header">
    <h1>客服</h1>
  </div>
  <p class="lead">
    RP主机的客服主要以支持单和邮件的方式提供，你可以与客服沟通你在使用中遇到的任何问题，例如你需要某个运行库，但服务器没有安装等等.<br />
    `额外技术支持版`中提供随叫随到的技术支持，帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务. 
    而标准版中，是否解答于服务器无关的问题(例如某个软件如何使用),视客服心情而定.
  </p>
  <p class="lead">
    客服邮箱：<code><i class="icon-envelope"></i>m@jybox.net</code> <code><i class="icon-envelope"></i>jyboxnet@gmail.com</code>
  </p>
</section>
<section id="agreement" style="min-height:500px;">
  <div class="page-header">
    <h1>政策和约定</h1>
  </div>
  <p class="lead">
    你必须遵守下列约定：
    <ul>
      <li>遵守服务器当地(均为中国大陆之外)的法律</li>
      <li>禁止放置容易引起GFW封杀的站点</li>
      <li>禁止放置容易遭到黑客攻击的站点,或故意吸引黑客的攻击</li>
      <li>禁止放置黑阔基地、色情、私服、垃圾邮件群发、虚假广告、诈骗类型的站点</li>
      <li>禁止放置大规模采集器生成的垃圾站点</li>
    </ul>
    如果无意违反以上约定，即不是以破坏RP主机为目的，警告一到两次.<br />
    如果故意或频繁违反以上约定，直接封停账户，不做退款.
  </p>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>

