<?php if(!isset($lpInTemplate)) die();

global $rpDomain,$rpROOT;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title = "用户手册";

lpTemplate::beginBlock();?>

<li class="active"><a href="#file-access"><i class="icon-chevron-right"></i> 文件权限</a></li>
<li><a href="#browser-support"><i class="icon-chevron-right"></i> 浏览器支持</a></li>
<li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
<li><a href="#ssh-sftp"><i class="icon-chevron-right"></i> 访问SSH和SFTP</a></li>
<li><a href="#data-backup"><i class="icon-chevron-right"></i> 数据备份</a></li>
<li><a href="#php"><i class="icon-chevron-right"></i> PHP支持</a></li>
<li><a href="#pptp"><i class="icon-chevron-right"></i> PPTP VPN</a></li>
<li><a href="#os-packets"><i class="icon-chevron-right"></i> 操作系统和软件包</a></li>
<li><a href="#website"><i class="icon-chevron-right"></i> Web服务概述</a></li>
<li><a href="#website-option"><i class="icon-chevron-right"></i> Web服务 选项帮助</a></li>
<li><a href="#mysql"><i class="icon-chevron-right"></i> MySQL数据库</a></li>
<li><a href="#domain"><i class="icon-chevron-right"></i> 域名绑定与解析</a></li>
<li><a href="#taskinfo-probe"><i class="icon-chevron-right"></i> 进程监视器和探针</a></li>
<li><a href="#third-party"><i class="icon-chevron-right"></i> 第三方服务推荐</a></li>

<?php
$tmp->rpSidebar=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<script type="text/javascript">
  $("a[rel=popover]")
  .popover({trigger:"hover"})
  .click(function(e) {
    e.preventDefault()
  });
</script>

<?php
$tmp->endOfBody=lpTemplate::endBlock();

?>


<section id="file-access">
  <div class="page-header">
    <h1>文件权限</h1>
  </div>
  <p class="lead">
    Apache2会以你的用户权限来访问网页文件，Nginx会以你的同组用户的权限访问你的网页.<br />
    因此，为了让Apache2和Nginx可以正确访问你的文件，且阻止RP主机上其他用户读写你的文件，你应当将所有文件的权限设置为770,或更低.
    <div class="alert alert-error" style="margin-top:10px;">
      <h4 class="alert-heading">注意!</h4>
      <p>如果你将文件设置为比770更宽松的权限，将导致同主机的其他用户可以读写你的文件，这样非常危险！！</p>
    </div>
    你可以使用下面的命令，将自己的所有文件的权限设置为770：<br />
    <code>
      <i class="icon-chevron-right"></i>chmod -R 770 ~
    </code>
  </p>
</section>

<section id="browser-support">
  <div class="page-header">
    <h1>浏览器支持</h1>
  </div>
  <p class="lead">
    该管理面板支持IE9、Chrome最新版、Firefox最新版、Opera最新版、Android/iOS浏览器.
  </p>
</section>

<section id="service">
  <div class="page-header">
    <h1>客服</h1>
  </div>
  <p class="lead">
    客服邮箱：<code><i class="icon-envelope"></i>m@jybox.net</code> <code><i class="icon-envelope"></i>jyboxnet@gmail.com</code><br />
    请发送邮件到上述邮箱，请勿使用linux中的mail机制.<br />
    客服(精英王子)：熟悉C++/Qt、PHP、Web前端、两年Linux使用和维护经验.
  <hr />
    在使用中遇到任何问题，都可以联系客服，例如需要某个运行库而没有安装等等.<br /><br />
  如果出现纠纷，你的邮箱将是最终认定账户所属权的依据。
  </p>
  <p class="lead">
    标准版中，与我们无关的问题(例如某个软件如何使用),是否详细解答要看客服的心情.<br />
    对于额外技术支持版,我们会尽最大努力为用户解决问题.
  </p>
  <div class="alert alert-error" style="margin-top:10px;">
    <h4 class="alert-heading">注意!</h4>
    <p>
      向客服发送邮件时请附上你的(面板)密码，以便确认身份。<br />
      如果客服向你索要敏感信息，请注意一定要回复到<code><i class="icon-envelope"></i>m@jybox.net</code>或<code><i class="icon-envelope"></i>jyboxnet@gmail.com</code>.
    </p>
  </div>
</section>

<section id="ssh-sftp">
  <div class="page-header">
    <h1>访问SSH和SFTP</h1>
  </div>
  <div class="alert alert-info" style="margin-top:10px;">
    <h4 class="alert-heading">提示!</h4>
    <p>
      首次开通用户，请登录你的管理面板来设置(修改)你的ssh密码.
    </p>
  </div>
  <p class="lead">
    Linux/Mac下，可直接在终端使用下列命令连接到RP主机的SSH(替换下面的用户名)：<br />
    <code>
      <i class="icon-chevron-right"></i>ssh 用户名@<?= $rpDomain;?>
    </code><br />
    Winodws下，可使用开源软件Putty连接SSH，Putty官网：<a href="http://www.putty.org/">http://www.putty.org</a>
    <hr />
    SFTP是经过加密的FTP，大部分FTP软件均支持SFTP，我们推荐使用FileZilla,它是开源而跨平台的：<br />
    FileZilla官网：<a href="http://filezilla-project.org/">http://filezilla-project.org</a>
  </p>
</section>

<section id="data-backup">
  <div class="page-header">
    <h1>数据备份</h1>
  </div>
  <p class="lead">
    一般情况下，每隔4-7天，我们会对所有数据进行一次备份。会备份到一些知名网盘，如Dropbox/百度网盘等。
  </p>
</section>

<section id="php">
  <div class="page-header">
    <h1>PHP支持</h1>
  </div>
  <p class="lead">
    最大POST文件限制：128M<br />
    显示错误报告：开<br /><br />
    其余选项保持默认，未禁用任何功能.
  </p>
</section>

<section id="pptp">
  <div class="page-header">
    <h1>PPTP VPN</h1>
  </div>
  <div class="alert alert-info" style="margin-top:10px;">
    <h4 class="alert-heading">提示!</h4>
    <p>
      首次开通用户，请登录你的管理面板来设置(修改)你的pptp密码.
    </p>
  </div>
  <p class="lead">
    服务器即<code><?= $rpDomain;?></code>，用户名即你的用户名.<br />
    设置方法可见(此教程并非本站内容)<a href="https://www.vcupmars.com/config">https://www.vcupmars.com/config</a>
  </p>
</section>

<section id="os-packets">
  <div class="page-header">
    <h1>操作系统和软件包</h1>
  </div>
  <p class="lead">
    <b>服务器操作系统 Ubuntu Server 12.04LTS</b>
    <br />
    <b>以下来自Ubuntu软件仓库，均为最新版</b>
    <br />
<pre>
apache2-mpm-itk apache2-dev php5 php5-cgi php5-cli libapache2-mod-php5
php5-mysql php5-curl php5-gd php5-idn php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-mhash php5-ming php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-sqlite php5-xsl
nginx mysql-server mysql-client phpmyadmin memcached pptpd
screen git wget zip unzip iftop rar unrar axel vim emacs subversion subversion-tools curl chkconfig ntp snmpd quota quotatool
python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv
g++ gcc qt4-dev-tools clang cmake
libevent-dev libnoise-dev
</pre>
    <b>以下来自pip软件仓库，均为最新版</b>
    <br />
<pre>
django tornado
</pre>
    <b>以下来自rvm</b>
    <br />
<pre>
ruby1.8.7 ruby1.9.3
</pre>
  </p>
</section>

<section id="website">
  <div class="page-header">
    <h1>Web服务概述</h1>
  </div>
  <p class="lead">
    RP主机使用Nginx+Apache2两层架构，Nginx处理反向代理、静态文件请求，Apache2处理脚本和CGI请求。<br />
    管理面板上的站点选项本质上是设置Nginx需要把哪些请求转给Apache处理。
  </p>
</section>

<section id="website-option">
  <div class="page-header">
    <h1>Web服务 选项帮助</h1>
  </div>
  <p class="lead">
    <b>站点ID</b> RP主机内部用来标识站点.
    <hr />
    <b>绑定的域名</b> 以空格隔开的域名列表.
    <hr />
    <b>站点模板</b> 有三个可选项：
    <ul>
      <li><b>常规Web(PHP等CGI)</b> 一般的Web服务器，包括PHP和其他CGI站点</li>
      <li><b>反向代理</b> 反向代理，通常用于代理本地端口，不适合用于CDN</li>
      <li><b>Python(WSGI模式)</b> 使用WSGI模式的PHP站点</li>
    </ul>
    <hr />
    <b>脚本处理策略</b> 只在<code>常规Web(PHP等CGI)</code>有效：
    <ul>
      <li><b>全部转到Apache</b> 将全部请求转交给Apache,即整个站点都是动态脚本</li>
      <li><b>仅转发指定的URL(一般是脚本文件)</b> 只将指定的后缀的URL转到Apache</li>
      <li><b>不转发指定的URL(一般是静态文件)</b> 只将指定的后缀的URL作为静态文件处理，不转发到Apache</li>
    </ul>
    <hr />
    <b>作为PHP脚本处理的后缀</b> 后缀名，以空格隔开，不包含点
    <hr />
    <b>作为CGI脚本处理的后缀</b> 后缀名，以空格隔开，不包含点
    <hr />
    <b>将404的请求转发到Apache(多用于URL重写)</b> 是否将不存在的文件请求转交给Apache，通常wordpress就需要这样
    <hr />
    <b>静态文件后缀</b> 后缀名，以空格隔开，不包含点
    <hr />
    <b>默认首页</b> 对于文件夹，默认显示的文件，以空格隔开
    <hr />
    <b>开启自动索引</b> 对于文件夹，如果没有默认首页，是否显示所有文件列表
    <hr />
    <b>Alias别名</b> 将某个特殊前缀的URL，绑定到指定目录，前缀和目录用空格隔开，每行一对，如：<br />
<pre>
/bbs /home/my/bbs/
</pre>
    <hr />
    <b>日志文件</b> Nginx和Apache2产生的访问日志和错误日志
    <hr />
    <b>SSL支持</b> 是否开启SSL支持
  </p>
</section>

<section id="mysql">
  <div class="page-header">
    <h1>MySQL数据库</h1>
  </div>
  <div class="alert alert-info" style="margin-top:10px;">
    <h4 class="alert-heading">提示!</h4>
    <p>
      首次开通用户，请登录你的管理面板来设置(修改)你的MySQL密码.<br />
      默认是没有数据库的，请登录Phpmyadmin自行创建数据库.
    </p>
  </div>
  <p class="lead">
    Web管理后台：<a href="/phpmyadmin">Phpmyadmin</a>
  </p>
</section>

<section id="domain">
  <div class="page-header">
    <h1>域名绑定与解析</h1>
  </div>
  <p class="lead">
    <b>绑定你自己的域名</b><br />
    将域名用CNAME解析到<code><?= $rpDomain;?></code>,然后即可在管理面板为你的网站绑定域名，多个域名在填写时以空格隔开。<br />
    在域名前可以加<code>*.</code>实现泛域名解析，如<code>*.xxoo.xo</code>
    <hr />
    <b>绑定三级域名</b><br />
    你可以随意绑定<code><?= $rpDomain;?></code>下的三级域名，如<code>xxoo.<?= $rpDomain;?></code>,只要其他人没有使用，你就可以绑定。
    <hr />
    <b>域名纠纷</b><br />
    每个域名只能被一个网站绑定，如果其他人绑定了属于你的域名，请联系客服，客服会帮助你解决纠纷。
  </p>
</section>


<section id="taskinfo-probe">
  <div class="page-header">
    <h1>进程监视器和探针</h1>
  </div>
  <p class="lead">
    <ul>
      <li><a href="/taskinfo.php">进程监视器</a></li>
      <li><a href="/probe.php">PHP探针</a></li>
      <li><a href="/mobile.php">PHP探针手机版</a></li>
      <li><a href="/top.php">top监视器</a></li>
    </ul>
  </p>
</section>

<section id="third-party">
  <div class="page-header">
    <h1>第三方服务推荐</h1>
  </div>
  <div>
    <b>企业邮箱</b>推荐腾讯的企业邮箱服务，免费、专业：<a href="http://exmail.qq.com/">http://exmail.qq.com</a>
    <hr class="small" />
    <b>CDN</b>推荐CloudFlare的免费CDN加速：<a href="https://www.cloudflare.com/">https://www.cloudflare.com</a>
    <hr class="small" />
    <b>翻墙</b>推荐基于GAE的GoAgent，开源、速度理想：<a href="https://code.google.com/p/goagent/">https://code.google.com/p/goagent</a>
    <hr class="small" />
    <b>备份</b>推荐Dropbox，免费、速度理想：<a href="https://www.dropbox.com/">https://www.dropbox.com</a>
  </div>
</section>

<?php

$tmp->output();

?>

