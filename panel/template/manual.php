<?php

$tmp = new lpTemplate;

$a["title"] = "用户手册";

lpBeginBlock();?>

<li class="active"><a href="#file-access"><i class="icon-chevron-right"></i> 文件权限</a></li>
<li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
<li><a href="#ssh-sftp"><i class="icon-chevron-right"></i> 访问SSH和SFTP</a></li>
<li><a href="#data-backup"><i class="icon-chevron-right"></i> 数据备份</a></li>
<li><a href="#third-party"><i class="icon-chevron-right"></i> 第三方服务推荐</a></li>

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

<section id="service">
  <div class="page-header">
    <h1>客服</h1>
  </div>
  <p class="lead">
    客服邮箱：<code><i class="icon-envelope"></i>m@jybox.net</code> <code><i class="icon-envelope"></i>jyboxnet@gmail.com</code><br />
    客服(精英王子)：熟悉C++/Qt、PHP、Web前端、两年Linux使用和维护经验.
  <hr />
    在使用中遇到任何问题，都可以联系客服，例如需要某个运行库而没有安装等等
  </p>
  <p class="lead">
    标准版中，与我们无关的问题(例如某个软件如何使用),是否详细解答要看客服的心情.<br />
    对于额外技术支持版,我们会尽最大努力为用户解决问题.
  </p>
  <div class="alert alert-error" style="margin-top:10px;">
    <h4 class="alert-heading">注意!</h4>
    <p>
      向客服发送邮件时请附上你的密码，以便确认身份。如果客服向你索要敏感信息，请注意一定要回复到
      <code><i class="icon-envelope"></i>m@jybox.net</code>或<code><i class="icon-envelope"></i>jyboxnet@gmail.com</code>.
    </p>
  </div>
</section>

<section id="ssh-sftp">
  <div class="page-header">
    <h1>访问SSH和SFTP</h1>
  </div>
  <p class="lead">
    Linux/Mac下，可直接在终端使用下列命令连接到RP主机的SSH(替换下面的用户名，和服务器域名)：<br />
    <code>
      <i class="icon-chevron-right"></i>ssh 用户名@rp.jybox.net
    </code>
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

<section id="third-party">
  <div class="page-header">
    <h1>第三方服务推荐</h1>
  </div>
  <p class="lead">
    <b>企业邮箱</b>推荐腾讯的企业邮箱服务，免费、专业：<a href="http://exmail.qq.com/">http://exmail.qq.com</a>
    <hr class="small" />
    <b>CDN</b>推荐CloudFlare的免费CDN加速：<a href="https://www.cloudflare.com/">https://www.cloudflare.com</a>
    <hr class="small" />
    <b>翻墙</b>推荐基于GAE的GoAgent，开源、速度理想：<a href="https://code.google.com/p/goagent/">https://code.google.com/p/goagent</a>
    <hr class="small" />
    <b>备份</b>推荐基于Dropbox，免费、速度理想：<a href="https://www.dropbox.com/">https://www.dropbox.com</a>
  </p>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>

