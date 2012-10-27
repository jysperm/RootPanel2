<?php
  global $rpDomain,$uiTemplate,$uiHander,$uiType;

  if(isset($new) && $new)
  {
      $rs['id']="XXOO";
      $id=substr(md5(time()),0,8);
      $rs["domains"]="{$id}.{$rpDomain}";
      $rs["template"]="web";
      $rs["type"]="only";
      $rs["php"]="php";
      $rs["cgi"]="";
      $rs["static"]="css js jpg gif png ico zip rar exe";
      $rs["indexs"]="index.php index.html index.htm";
      $rs["autoindex"]=1;
      $rs["is404"]=1;
      $uname=lpAuth::getUName();
      $rs["root"]="/home/{$uname}/web/";
      $rs["alias"]="{}";
      $rs["nginxaccess"]="/home/{$uname}/nginx.access.log";
      $rs["nginxerror"]="/home/{$uname}/nginx.error.log";
      $rs["apacheaccess"]="/home/{$uname}/apache.access.log";
      $rs["apacheerror"]="/home/{$uname}/apache.error.log";
      $rs["isssl"]=0;
      $rs["sslkey"]="";
      $rs["sslcrt"]="";
  }
?>

<form class="rp-form">
  <div>
    站点ID：<span class="label"><?= $rs["id"];?></span>
  </div>
  <div>
      绑定的域名：<input type="text" class="input-xxlarge" id="domains" name="domains" value="<?= trim(str_replace("  "," ",$rs["domains"]));?>" required="required" />
  </div>
  <div class="box">
    <header>站点模板：</header>
    <label class="radio">
      <input type="radio" name="optemplate" id="opweb" value="web" <?= ($rs["template"]=="web")?"checked='checked'":"";?> />
      常规Web(PHP等CGI)
    </label>
    <label class="radio">
      <input type="radio" name="optemplate" id="opproxy" value="proxy" <?= ($rs["template"]=="proxy")?"checked='checked'":"";?> />
      反向代理
    </label>
    <label class="radio">
      <input type="radio" name="optemplate" id="oppython" value="python" <?= ($rs["template"]=="python")?"checked='checked'":"";?> />
      Python(WSGI模式)
    </label>
    <div class="div-web<?= ($rs["template"]!="web")?" hide":"";?>">
      <div class="box">
        <header>脚本处理策略：</header>
        <label class="radio">
        <input type="radio" name="optype" id="opall" value="all" <?= ($rs["type"]=="all")?"checked='checked'":"";?> />
          全部转到Apache
        </label>
        <label class="radio">
          <input type="radio" name="optype" id="oponly" value="only" <?= ($rs["type"]=="only")?"checked='checked'":"";?> />
          仅转发指定的URL(一般是脚本文件)
        </label>
        <label class="radio">
          <input type="radio" name="optype" id="opunless" value="unless" <?= ($rs["type"]=="unless")?"checked='checked'":"";?> />
          不转发指定的URL(一般是静态文件)
        </label>
      </div>
      <div class="div-only<?= ($rs["type"]!="only")?" hide":"";?>">
        作为PHP脚本处理的后缀：<input type="text" class="input-xxlarge" id="php" name="php" value="<?= trim(str_replace("  "," ",$rs["php"]));?>" /><br />
        作为CGI脚本处理的后缀：<input type="text" class="input-xxlarge" id="cgi" name="cgi" value="<?= trim(str_replace("  "," ",$rs["cgi"]));?>" />
        <label class="checkbox">
          <input type="checkbox" id="is404" name="is404" <?= ($rs["is404"])?"checked='checked'":"";?> />
          将404的请求转发到Apache(多用于URL重写)
        </label>
      </div>
      <div class="div-unless<?= ($rs->type!="unless")?" hide":"";?>">
        静态文件后缀:<input type="text" class="input-xxlarge" id="static" name="static" value="<?= trim(str_replace("  "," ",$rs["static"]));?>" />
      </div>
      默认首页：<input type="text" class="input-xxlarge" id="indexs" name="indexs" value="<?= trim(str_replace("  "," ",$rs["indexs"]));?>" />
      <label class="checkbox">
        <input type="checkbox" id="autoindex" name="autoindex" <?= ($rs["autoindex"])?"checked='checked'":"";?> />
        开启自动索引
      </label>
    </div>
    <div class="div-python<?= ($rs["template"]!="python")?" hide":"";?>">
      默认首页：<input type="text" class="input-xxlarge" id="pyindexs" name="pyindexs" value="<?= trim(str_replace("  "," ",$rs["indexs"]));?>" />
      <label class="checkbox">
        <input type="checkbox" id="pyautoindex" name="pyautoindex" <?= ($rs["autoindex"])?"checked='checked'":"";?> />
        开启自动索引
      </label>
    </div>
    <span class="rp-root-name"><?= $uiHander[$rs["template"]];?></span>：<input type="text" class="input-xxlarge" id="root" name="root" value="<?= trim(str_replace("  "," ",$rs["root"]));?>" />
  </div>
  <div>
Alias别名(URL别名和绑定到的目录以空格隔开,一行一对)：<br />
<textarea id="alias" name="alias" rows="4">
<?php
$alias=json_decode($rs["alias"],true);
foreach($alias as $k => $v)
{
    echo "$k $v\n";
}
?>
</textarea>
  </div>
  <hr />
  <div>
    Nginx Access日志：<input type="text" class="input-xxlarge" id="nginxaccess" name="nginxaccess" value="<?= $rs["nginxaccess"];?>" /><br />
    Nginx Error日志：<input type="text" class="input-xxlarge" id="nginxerror" name="nginxerror" value="<?= $rs["nginxerror"];?>" /><br />
    Apache Access日志：<input type="text" class="input-xxlarge" id="apacheaccess" name="apacheaccess" value="<?= $rs["apacheaccess"];?>" /><br />
    Apache Error日志：<input type="text" class="input-xxlarge" id="apacheerror" name="apacheerror" value="<?= $rs["apacheerror"];?>" />
  </div>
  <hr />
  <div>
    <label class="checkbox">
      <input type="checkbox" id="isssl" name="isssl" <?= ($rs["isssl"])?"checked='checked'":"";?> />
      SSL支持
    </label>
    SSL Crt(证书)：<input type="text" class="input-xxlarge" id="sslcrt" name="sslcrt" value="<?= $rs["sslcrt"];?>" /><br />
    SSL Key(私玥)：<input type="text" class="input-xxlarge" id="sslkey" name="sslkey" value="<?= $rs["sslkey"];?>" />
  </div>
</form>
