<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$adminQQ = 184300584;

$rpL["contact.email"] = "邮件";
$rpL["contact.service"] = "咨询";

$rpL["contact.qqButton"] = <<< HTML

<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminQQ}&site=qq&menu=yes">
  <img border="0" src="http://wpa.qq.com/pa?p=2:{$adminQQ}:41" alt="QQ {$adminQQ}" title="QQ {$adminQQ}">
</a>

HTML;

$rpL["contact.list"] = <<< HTML

<li>
    <a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=2b0b1ba412ccb567774192aac996c5cd62aefd65a71773f9a01badb6968072ac">
        <img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="RP主机用户群" title="RP主机用户群">
    </a>
</li>
<li>{$rpL["contact.qqButton"]}</li>
<li>
  <a target="_blank" href="http://amos.alicdn.com/msg.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" >
    <img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" alt="阿里旺旺" />
  </a>
</li>

HTML;

return $rpL;
