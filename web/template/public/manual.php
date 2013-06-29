<?php

global $rpROOT, $rpCfg, $tooltip;

$rpDomain = $rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"];

$base = new lpTemplate("{$rpROOT}/template/base.php");

$base['title'] = "用户手册";
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#file-access"><i class="icon-chevron-right"></i> 文件权限</a></li>
<li><a href="#browser-support"><i class="icon-chevron-right"></i> 浏览器支持</a></li>
<li><a href="#service"><i class="icon-chevron-right"></i> 客服支持</a></li>
<li><a href="#ssh-sftp"><i class="icon-chevron-right"></i> 访问SSH和SFTP</a></li>
<li><a href="#data-backup"><i class="icon-chevron-right"></i> 数据备份</a></li>
<li><a href="#php"><i class="icon-chevron-right"></i> PHP支持</a></li>
<li><a href="#pptp"><i class="icon-chevron-right"></i> PPTP VPN</a></li>
<li><a href="#os-packets"><i class="icon-chevron-right"></i> 操作系统和软件包</a></li>
<li><a href="#website"><i class="icon-chevron-right"></i> Web服务概述</a></li>
<li><a href="#mysql"><i class="icon-chevron-right"></i> MySQL数据库</a></li>
<li><a href="#domain"><i class="icon-chevron-right"></i> 域名绑定与解析</a></li>
<li><a href="#taskinfo-probe"><i class="icon-chevron-right"></i> 进程监视器和探针</a></li>
<li><a href="#third-party"><i class="icon-chevron-right"></i> 第三方服务推荐</a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<section id="file-access">
    <header>文件权限</header>
    <p>
        Apache2会以你的用户权限来访问网页文件，Nginx会以你的同组用户的权限访问你的网页.<br/>
        因此，为了让Apache2和Nginx可以正确访问你的文件，且阻止RP主机上其他用户读写你的文件，你应当将所有文件的权限设置为770, 或更低.

    <div class="alert alert-error">
        <h4 class="alert-heading">注意!</h4>

        <p>如果你将文件设置为比770更宽松的权限，将导致同主机的其他用户可以读写你的文件，这样非常危险！！</p>
    </div>
    你可以使用下面的命令，将自己的所有文件的权限设置为770：<br/>
    <code>
        <i class="icon-chevron-right"></i>chmod -R 770 ~
    </code>
    </p>
</section>

<section id="browser-support">
    <header>浏览器支持</header>
    <p>
        该管理面板支持IE10、Chrome、Firefox、Opera.<br/>
        对IE9有不完整支持.<br/>
        在Android/iOS等移动平台，因为屏幕分辨率太小，显示效果欠佳.
    </p>
</section>

<section id="service">
    <header>客服支持</header>
    <p>
        客服会帮你解决：
    </p>
    <ul>
        <li>服务器出现故障，或你认为服务器出现了故障</li>
        <li>需要某个运行库、软件包，但服务器没有安装</li>
        <li>其他人占用了本属于你的域名，或尝试对你的账户进行破坏</li>
        <li>发现其他用户的站点不符合`政策和约定`, 可能影响到你</li>
        <li>使用Linux, PHP, Python等等软件时遇到困难</li>
    </ul>
    <div class="alert alert-error">
        <h4 class="alert-heading">注意!</h4>
        <ul>
            <li>请勿使用linux中的mail机制</li>
            <li>如果客服向你索要敏感信息，请注意一定要回复到下列邮箱，以免被钓鱼</li>
            <li>如果账户归宿出现纠纷，那么你的邮箱将会是最终的认定依据</li>
        </ul>
    </div>
    <p>
        <? $emails = []; ?>
        <? foreach($rpCfg["Admins"] as $adminID => $admin): ?>
            <? $adminInfo = "{$admin['description']}<br />QQ: {$admin['qq']}<br />E-mail: {$admin['email']}"; ?>
            <a class="admin" target="_blank" href="<?= $admin["url"]; ?>" rel="popover"
               data-content="<?= $adminInfo; ?>" data-original-title="客服：<?= $admin["name"]; ?>">
                <img alt="<?= $admin["name"]; ?>" src="<?= rpTools::gravatarURL($admin["email"], 48); ?>">
            </a>
            <? $emails[] = $admin["email"]; ?>
        <? endforeach; ?>
    </p>
    <ul class="left-tabs">
        <?= $tooltip["contact"];?>
    </ul>
</section>

<section id="ssh-sftp" style="clear: both;">
    <header>访问SSH和SFTP</header>
    <div class="alert alert-info">
        <h4 class="alert-heading">提示!</h4>

        <p>
            首次开通用户，请登录你的管理面板来设置(修改)你的ssh密码.
        </p>
    </div>
    <p>
        Linux/Mac下，可直接在终端使用下列命令连接到RP主机的SSH(替换下面的用户名)：<br/>
        <code>
            <i class="icon-chevron-right"></i>ssh 用户名@<?= $rpDomain;?>
        </code>
        <br/>
        Winodws下，可使用开源软件Putty连接SSH，Putty官网：<a href="http://www.chiark.greenend.org.uk/~sgtatham/putty/">http://www.chiark.greenend.org.uk/~sgtatham/putty/</a>
    <hr/>
    SFTP是经过加密的FTP，大部分FTP软件均支持SFTP，我们推荐使用FileZilla,它是开源而跨平台的：<br/>
    FileZilla官网：<a href="http://filezilla-project.org/">http://filezilla-project.org</a>
    </p>
</section>

<section id="data-backup">
    <header>数据备份</header>
    <p>
        一般情况下，每隔4-7天，我们会对所有数据进行一次备份. 会备份到一些知名网盘，如Dropbox/百度网盘等.
    </p>
</section>

<section id="php">
    <header>PHP支持</header>
    <p>
        最大POST文件限制：128M<br/>
        显示错误报告：开<br/><br/>
        其余选项保持默认，未禁用任何功能.
    </p>
</section>

<section id="pptp">
    <header>PPTP VPN</header>
    <div class="alert alert-info">
        <h4 class="alert-heading">提示!</h4>

        <p>
            首次开通用户，请登录你的管理面板来设置(修改)你的pptp密码.
        </p>
    </div>
    <p>
        服务器即<code><?= $rpDomain;?></code>，用户名即你的用户名.<br/>
        设置方法可见(此教程并非本站内容)<a href="https://www.vcupmars.com/config">https://www.vcupmars.com/config</a>
    </p>
</section>

<section id="os-packets">
    <header>操作系统和软件包</header>
    <p>
        <b>服务器操作系统 Ubuntu Server 12.04 LTS</b>
        <br/>
        <b>以下来自Ubuntu软件仓库，均为最新版</b>
        <br/>
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
    <br/>
<pre>
django tornado
</pre>
    <b>以下来自rvm</b>
    <br/>
<pre>
ruby1.8.7 ruby1.9.3
</pre>
    </p>
</section>

<section id="website">
    <header>Web服务概述</header>
    <p>
        RP主机使用Nginx+Apache2两层架构，Nginx处理反向代理、静态文件请求，Apache2处理脚本和CGI请求。<br/>
        管理面板上的站点选项本质上是设置Nginx需要把哪些请求转给Apache处理。
    </p>
</section>

<section id="mysql">
    <header>MySQL数据库</header>
    <div class="alert alert-info">
        <h4 class="alert-heading">提示!</h4>

        <p>
            首次开通用户，请登录你的管理面板来设置(修改)你的MySQL密码.<br/>
            默认是没有数据库的，请登录Phpmyadmin自行创建数据库.
        </p>
    </div>
    <p>
        Web管理后台：<a href="/phpmyadmin">Phpmyadmin</a>
    </p>
</section>

<section id="domain">
    <header>域名绑定与解析</header>
    <p>
        <b>绑定你自己的域名</b><br/>
        将域名用CNAME解析到<code><?= $rpDomain;?></code>,然后即可在管理面板为你的网站绑定域名，多个域名在填写时以空格隔开。<br/>
        在域名前可以加<code>*.</code>实现泛域名解析，如<code>*.xxoo.xo</code>
    <hr/>
    <b>绑定三级域名</b><br/>
    你可以随意绑定<code><?= $rpDomain;?></code>下的三级域名，如<code>xxoo.<?= $rpDomain;?></code>,只要其他人没有使用，你就可以绑定。
    <hr/>
    <b>域名纠纷</b><br/>
    每个域名只能被一个网站绑定，如果其他人绑定了属于你的域名，请联系客服，客服会帮助你解决纠纷。
    </p>
</section>

<section id="taskinfo-probe">
    <header>进程监视器和探针</header>
    <p>
    <ul>
        <li><a href="/taskinfo.php">进程监视器</a></li>
        <li><a href="/probe.php">PHP探针</a></li>
        <li><a href="/mobile.php">PHP探针手机版</a></li>
        <li><a href="/top.php">top监视器</a></li>
    </ul>
    </p>
</section>

<section id="third-party">
    <header>第三方服务推荐</header>
    <ul>
        <li><b>企业邮箱</b>推荐腾讯的企业邮箱服务，免费、专业：<a href="http://exmail.qq.com/">http://exmail.qq.com</a></li>
        <li><b>CDN</b>推荐CloudFlare的免费CDN加速：<a href="https://www.cloudflare.com/">https://www.cloudflare.com</a></li>
        <li><b>接入世界性互联网</b>推荐基于GAE的GoAgent，开源、速度理想：<a href="https://code.google.com/p/goagent/">https://code.google.com/p/goagent</a>
        </li>
        <li><b>备份</b>推荐Dropbox，免费、速度理想：<a href="https://www.dropbox.com/">https://www.dropbox.com</a></li>
    </ul>
</section>

<? $base->output(); ?>

