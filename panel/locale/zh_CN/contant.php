<?php

global $rpCfg, $rpL;

$adminQQ = array_values($rpCfg["Admins"])[0]["qq"];

$rpL["contant.qqButton"] = <<< HTML

<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminQQ}&site=qq&menu=yes">
  <img border="0" src="http://wpa.qq.com/pa?p=2:{$adminQQ}:41" alt="QQ {$adminQQ}" title="QQ {$adminQQ}">
</a>

HTML;

$rpL["contact.list"] = <<< HTML

<li>QQ群 12959991</li>
<li>{$rpL["contant.qqButton"]}</li>
<li>
  <a target="_blank" href="http://amos.alicdn.com/msg.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" >
    <img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid=jy%E7%B2%BE%E8%8B%B1%E7%8E%8B%E5%AD%90&site=cntaobao&s=1&charset=utf-8" alt="阿里旺旺" />
  </a>
</li>

HTML;
