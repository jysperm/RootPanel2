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

$rpM["resetPasswdEMail"] = <<< ECF

请用你的注册邮箱，向客服邮箱<code><i class="icon-envelope"></i>{$adminEMail}</code>发送邮件.

ECF;

$rpM["resetPasswdQQ"] = <<< ECF

使用你设置的QQ, 联系客服 {$rpM["qqButtun"]}.

ECF;



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

