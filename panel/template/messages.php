<?php

global $rpCfg, $rpM;

$adminQQ = array_values($rpCfg["Admins"])[0]["qq"];

$rpM["qqButtun"] = <<< EOF

<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminQQ}&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:{$adminQQ}:41" alt="QQ {$adminQQ}" title="QQ {$adminQQ}"></a>

EOF;


/* ----- index.php ----- */

$rpM["free"] = <<< EOF

CPU时间限制(按天)：500秒(相当于0.6%)<br />
最小内存保证：10M<br />
内存竞争系数：0.4(与付费用户竞争内存时的系数)<br />
硬盘限制：300M<br />
流量限制(按天)：300M<br />
流量限制(按月)：3G<br />

EOF;

$rpM["evn"] = "RP主机提供了完整的Linux环境，即使RP主机默认不提供某语言的运行环境，你也可以通过Linux下安装软件的常规方式自行安装该语言环境.";

$rpM["ext"] = "帮助你解决网站架设、linux及其周边软件的问题，在您寂寞时还提供陪聊服务.";

$rpM["proxy"] = <<< EOF

<ul>
<li>Secure Shell</li>
<li>Virtual Private Network</li>
<li>(Point to Point Tunneling Protocol)</li>
<li>ShadowSocks</li>
</ul>

EOF;

$rpM["site"] = <<< EOF

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

EOF;

$rpM["agreement"] = <<< EOF

<section id="agreement">
  <header>政策和约定</header>
  <p><b>你必须遵守下列约定</b>：</p>
  <ul>
    <li>遵守服务器当地的法律</li>
    <li>禁止放置容易引起GFW封杀的站点</li>
    <li>禁止放置容易遭到黑客攻击的站点,或故意吸引黑客的攻击</li>
    <li>禁止放置黑阔基地、色情、私服、垃圾邮件群发、虚假广告、诈骗类型的站点</li>
    <li>禁止放置大规模采集器生成的垃圾站点</li>
  </ul>
  <p>
    如果无意违反以上约定，即不是以破坏RP主机为目的，警告一到两次.<br />
    如果故意或频繁违反以上约定，直接封停账户，不做退款.
  </p>
  <p><b>数据和隐私</b>：</p>
  <ul>
    <li>你绑定的域名不属于隐私，我们会通过浏览器定期审查你的站点，但不会直接查看你的文件</li>
    <li>你的文件和数据库未经你允许，不会被人工查看。当你发邮件要求客服协助解决问题时，在必要的范围内，客服会查看你的文件以解决问题</li>
    <li>根据Linux的一些规则，你的部分信息可能会被其他用户获得，例如你的用户名、进程列表等，具体请了解Linux的使用</li>
    <li>我们每周会向一些知名的网盘备份数据，如Dropbox/百度网盘等等，我们会尽力保证相关帐号的安全</li>
    <li>上游服务商(网络提供商、VPS运营商)的故障我们无能为力，但会做适度的补偿</li>
  </ul>
  <p>
    以上约定基于隐私和安全的折中考虑，以保证不会因为其他用户的不良站点影响到你.<br />
    即使如此，我们还是会尽可能地防止无关的人得到以上信息.
  </p>
  <p>
    <b>优惠</b>：<br />
    RP主机会不定期推出优惠措施，所有优惠措施均为在原有时长基础上增加时长，而不是降低价格。<br />
    例如标准版如果八折优惠，那么价格仍然是8元每月，但是会增加6天的使用时长。<br />
    额外增加的时长不参与退款。
  </p>
</section>

EOF;

/* ----- signup.php ----- */

$rpM["contact"] = <<< EOF

<li>QQ群 12959991</li>
<li><a target="_blank" href="http://rp-bbs.jybox.net">用户论坛</a></li>
<li>{$rpM["qqButtun"]}</li>
<li><a target="_blank" href="http://amos.alicdn.com/msg.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" ><img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" alt="阿里旺旺" /></a></li>

EOF;

$rpM["signupRule"] = <<< EOF

<ul>
  <li>帐号仅可以使用英文、数字、下划线,且第一个字符必须为英文字母</li>
  <li>邮箱务必为正确的邮箱地址</li>
</ul>

EOF;

/* ----- login.php ----- */

$adminEMail = array_values($rpCfg["Admins"])[0]["email"];

$rpM["resetPasswdEMail"] = <<< EOF

请用你的注册邮箱，向客服邮箱<code><i class="icon-envelope"></i>{$adminEMail}</code>发送邮件.

EOF;

$rpM["resetPasswdQQ"] = <<< EOF

使用你设置的QQ, 联系客服 {$rpM["qqButtun"]}.

EOF;

/* ----- pay-free.php ----- */

$rpM["requstSendOk"] = <<< EOF

<script type="text/javascript">
    alert("发送成功，请耐心等待回复，不要重复发送...");
    window.location.href = "/";
</script>

EOF;

/* ----- node-list.php ----- */

$rpM["minRes"] = <<< EOF

最小保证即任何情况下都可以保证这么多的资源，如果服务器还剩余资源，则所有需要资源的账户均分剩余资源.<br />
例如服务器剩余100M内存，有两个用户需要更多内存，则每人分得50M额外内存.

EOF;

$rpM["rp1"] = <<< EOF

总所周知Linode是业界良心，质量和稳定性都有保证，且日本线路到大陆比较近.<br />
但Linode流量较少，且该区域受到工信部重点关照，时常访问不畅.

EOF;

$rpM["rp2"] = <<< EOF

这个节点资源较多，无论是硬盘、内存、流量都较大.<br />
到大陆的速度也可以接受，而且该区域目前还未受到特殊关照.

EOF;

$rpM["rp3"] = <<< EOF

目前该节点用于进行面板和相关自动化脚本的测试，不接受付费用户.

EOF;

/* ----- panel.php ----- */

$rpM["isonHelp"] = "表示网站是否被开启，只有开启了网站，才可以正常访问. 未开启则表示这仅仅是个网站设置的备份，未被启用";
$rpM["idHelp"] = "每个站点有个唯一的ID, 在向客服求助时，可以很方便地指明所描述的站点";
$rpM["domainHelp"] = "该站点所绑定的域名，更多参见请用户手册的`域名绑定与解析`";
$rpM["typeHelp"] = "该站点的类型模版，更多类型请点`修改`按钮";
$rpM["sourceHelp"] = "该站点的数据来源，站点类型不同，来源的类型也不同";
$rpM["extconfHelp"] = "如果该面板不能满足你奇葩的需求，那么你可以要求客服为你手写配置文件，额外的配置文件会显示在这里";

$rpM["uiUserType"] = [
    "no" => "未购买",
    "free" => "免费试用版",
    "std" => "标准付费版",
    "ext" => "额外技术支持版"
];

$rpM["uiHostType"] = [
    "apache2" => "Apache",
    "static" => "Nginx纯静态",
    "uwsgi" => "uWSGI(Python)",
    "phpfpm" => "PHP-FPM",
    "proxy" => "反向代理"
];

/* ----- logs.php ----- */

$rpM["logidHelp"] = "每条日志有个唯一的ID, 可以很方便地向客服指明你所说的那条日志";
$rpM["byHelp"] = "该条消息的触发者，可能是你自己，也可能是管理员";
$rpM["ipuaHelp"] = "操作者的IP, 悬停鼠标会显示UA";

/* ----- sites.php ----- */

$rpM["img300x200"] = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAADICAYAAABS39xVAAAJXklEQVR4Xu3bv2sUaxQG4AmiqKCl2onYai3471vZiJ3YCWIhSLDRxh+5zMKE787dmDPZqO/JfQQbOdm8+5wvL7OT8ej4+Phk8ocAAQINBI4UVoMtiUiAwE5AYTkIBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2qxKUAAGF5QwQINBGQGG1WZWgBAgoLGeAAIE2AgqrzaoEJUBAYTkDBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2qxKUAAGF5QwQINBGQGG1WZWgBAgoLGeAAIE2AgqrzaoEJUBAYTkDBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2qxKUAAGF5QwQINBGQGG1WZWgBAgoLGeAAIE2AgqrzaoEJUBAYTkDBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2qxKUAAGF5QwQINBGQGG1WZWgBAgoLGeAAIE2AgqrzaoEJUBAYTkDBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2qxKUAAGF5QwQINBGQGG1WZWgBAgoLGeAAIE2AgqrzaoEJUBAYTkDBAi0EVBYbVYlKAECCssZIECgjYDCarMqQQkQUFjOAAECbQQUVptVCUqAgMJyBggQaCOgsNqsSlACBBSWM0CAQBsBhdVmVYISIKCwnAECBNoIKKw2q/p10J8/f04vX76cvnz58q/BJ0+eTA8ePPjPF79582b68OHD6b8fHR1Nz58/n27dunXQbJXzrLx37tyZnj17dlCGLe+tmtdchoDCytjDQSm+f/8+vXjxYvrx48e0FNT79++nt2/f7l730aNH0+PHj0+/x/IDvZTUp0+fdrP7SmvLbPVNHB8fT69fv57m0lryju9hXVpbMmyZreY1lyOgsHJ2ceEkSzndvHlzd3Vy/fr13Wu9evVqmsthLICxLMYiO3R2S/ilVNbFtLyPsTgT8m55b2Z/r4DC+r2+f+TV9/2gj4V1//796enTp7ssS1msy23fa2yZ3fJGx49s40fWpZxOTk5OP55uybBldkteszkCCitnF5eaZN8P73jfaH11s/6Ydu/evdN7YufN7rtHdpE3s75SvHbtWjnD38h7kffoaw4TUFiH+UV99XgfaA62LpqxsMarrnl2/Nr5o+L8d7mJf97sjRs3Tu+Xza81X73Nfz9//nzqs76PtoYbsy2zvyvveD8vaoHCnCugsM4l6jkw3nTfd2P7vBJ6+PDh6Y3882bnAljf+F+ueL5+/Xrmbx9H2eUe2lhs42uel2Fr3p5blVphXeEzsP5YOH7EOq8AtlxhLVcsS8HMV0ZzYX38+PH0t4C/Yt5XVvO8K6wrfDgv+NYU1gXhOnzZIfelLnpPaPye61KsfAwcZ9LvuXU4A1cto8K6AhtdP3u0PPy573mnLb9J2zK7MI7fc/2byLPK6KyHW+f5LRm2zF6Btf8v34LCugJrXz5SrR/8/NPPNS0fCW/fvj3dvXt39yT9vifXxyundVktmZd/9xzWFTigl/gWFNYlYv6tl9p3JXXWD/p41bIU3Lt373blUnnS/azZpYTmp+2Xh1eXIl1/NFyuhNZlNd4DG/+b0PoK8jLy/q1d+b6HCSisw/xivnosqDHUn/i/hONvJOfvPRfUt2/fdk/ZL3+WK631oxf7APd9lNzy/wO3zMYsUJCSgMIqMRkiQCBBQGElbEEGAgRKAgqrxGSIAIEEAYWVsAUZCBAoCSisEpMhAgQSBBRWwhZkIECgJKCwSkyGCBBIEFBYCVuQgQCBkoDCKjEZIkAgQUBhJWxBBgIESgIKq8RkiACBBAGFlbAFGQgQKAkorBKTIQIEEgQUVsIWZCBAoCSgsEpMhggQSBBQWAlbkIEAgZKAwioxGSJAIEFAYSVsQQYCBEoCCqvEZIgAgQQBhZWwBRkIECgJKKwSkyECBBIEFFbCFmQgQKAkoLBKTIYIEEgQUFgJW5CBAIGSgMIqMRkiQCBBQGElbEEGAgRKAgqrxGSIAIEEAYWVsAUZCBAoCSisEpMhAgQSBBRWwhZkIECgJKCwSkyGCBBIEFBYCVuQgQCBkoDCKjEZIkAgQUBhJWxBBgIESgIKq8RkiACBBAGFlbAFGQgQKAkorBKTIQIEEgQUVsIWZCBAoCSgsEpMhggQSBBQWAlbkIEAgZKAwioxGSJAIEFAYSVsQQYCBEoCCqvEZIgAgQQBhZWwBRkIECgJKKwSkyECBBIEFFbCFmQgQKAkoLBKTIYIEEgQUFgJW5CBAIGSgMIqMRkiQCBBQGElbEEGAgRKAgqrxGSIAIEEAYWVsAUZCBAoCSisEpMhAgQSBBRWwhZkIECgJKCwSkyGCBBIEFBYCVuQgQCBkoDCKjEZIkAgQUBhJWxBBgIESgIKq8RkiACBBAGFlbAFGQgQKAkorBKTIQIEEgQUVsIWZCBAoCSgsEpMhggQSBBQWAlbkIEAgZKAwioxGSJAIEFAYSVsQQYCBEoCCqvEZIgAgQQBhZWwBRkIECgJKKwSkyECBBIEFFbCFmQgQKAkoLBKTIYIEEgQUFgJW5CBAIGSgMIqMRkiQCBBQGElbEEGAgRKAgqrxGSIAIEEAYWVsAUZCBAoCSisEpMhAgQSBBRWwhZkIECgJKCwSkyGCBBIEFBYCVuQgQCBkoDCKjEZIkAgQUBhJWxBBgIESgIKq8RkiACBBAGFlbAFGQgQKAkorBKTIQIEEgQUVsIWZCBAoCSgsEpMhggQSBBQWAlbkIEAgZKAwioxGSJAIEFAYSVsQQYCBEoCCqvEZIgAgQQBhZWwBRkIECgJKKwSkyECBBIEFFbCFmQgQKAk8A+VGQo6IwyiOwAAAABJRU5ErkJggg==";