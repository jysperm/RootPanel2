<?php if(!isset($lpInTemplate)) die();

global $uiTemplate,$uiHander,$uiType,$uiUserType,$rpROOT;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->mainClass = "main50";
$tmp->title = "控制面板主页";

lpTemplate::beginBlock();?>


<?php
$tmp->header=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<li><a href="#box-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#box-account"><i class="icon-chevron-right"></i> 账户</a></li>
<li><a href="#box-website"><i class="icon-chevron-right"></i> Web站点管理</a></li>
<li><a href="#box-log"><i class="icon-chevron-right"></i> 日志</a></li>

<?php
$tmp->rpSidebar=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<script type="text/javascript">
  function deleteWebsite(websiteId)
  {
      if(confirm("你确定要删除？"))
      {
          $.post("/commit/panel/",{"do":"delete","id":websiteId},function(data){
            if(data.status=="ok")
                window.location.reload();
            else
                alert(data.msg);
          },"json");
      }
      return false;
  }
  
  function bindSwitch()
  {
      $("#editWebsite #opweb").click(function(){
          $("#editWebsite .div-web").show();
          $("#editWebsite .rp-root-name").html("Web根目录");
          $("#editWebsite .div-python").hide();
      });

      $("#editWebsite #opproxy").click(function(){
          $("#editWebsite .div-web").hide();
          $("#editWebsite .rp-root-name").html("反向代理URL");
          $("#editWebsite .div-python").hide();
      });

      $("#editWebsite #oppython").click(function(){
          $("#editWebsite .div-web").hide();
          $("#editWebsite .rp-root-name").html("Web根目录");
          $("#editWebsite .div-python").show();
      });

      $("#editWebsite #opall").click(function(){
          $("#editWebsite .div-only").hide();
          $("#editWebsite .div-unless").hide();
      });

      $("#editWebsite #oponly").click(function(){
          $("#editWebsite .div-only").show();
          $("#editWebsite .div-unless").hide();
      });

      $("#editWebsite #opunless").click(function(){
          $("#editWebsite .div-only").hide();
          $("#editWebsite .div-unless").show();
      });
  }
  
  function editWebsite(websiteId)
  {
      $("#editWebsite .rp-title").html("编辑站点");
      $.post("/commit/panel/",{"do":"get","id":websiteId},function(data){
        $("#editWebsite .rp-body").html(data);

        bindSwitch();
        
        $("#editWebsite .rp-ok").unbind('click');
        $("#editWebsite .rp-ok").click(function(){
            postdata=$("#editWebsite .rp-form").serializeArray();
            postdata.push({name:"id",value:websiteId});
            postdata.push({name:"do",value:"edit"});
            $.post("/commit/panel/", postdata,function(data){
                if(data.status=="ok")
                    window.location.reload();
                else
                    alert(data.msg);
            },"json");
            return false;
        });
        
        $("#editWebsite").modal();
      },"html");
      
      return false;
  }
  
  $($("#new-website").click(function(){
    $("#editWebsite .rp-title").html("新增站点");
    $.post("/commit/panel/",{"do":"getnew"},function(data){
      $("#editWebsite .rp-body").html(data);

      bindSwitch();
      
      $("#editWebsite .rp-ok").unbind('click');
      $("#editWebsite .rp-ok").click(function(){
          postdata=$("#editWebsite .rp-form").serializeArray();
          postdata.push({name:"do",value:"add"});
          $.post("/commit/panel/", postdata,function(data){
              if(data.status=="ok")
                  window.location.reload();
              else
                  alert(data.msg);
          },"json");
          return false;
      });
      
      $("#editWebsite").modal();
    },"html");
  }));
  
  function changePasswd(name,isReload)
  {
    $.post("/commit/panel/",{"do":name,"passwd":$("#"+name).val()},function(data){
      if(data.status=="ok")
      {
        if(isReload)
          window.location.reload();
        else
          alert(data.status);
      }
      else
        alert(data.msg);
    },"json");
    return false;
  }
</script>

<?php
$tmp->endOfBody=lpTemplate::endBlock();

$conn=new lpMySQL;
$rs=$conn->select("virtualhost",array("uname"=>lpAuth::getUName()));
$rsL=$conn->select("log",array("uname"=>lpAuth::getUName()),"time",-1,30,false);
$rsU=$conn->select("user",array("uname"=>lpAuth::getUName()));
$rsU->read();

?>

<div class="modal hide" id="editWebsite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="rp-title"></h3>
  </div>
  <div class="modal-body rp-body">
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button class="btn btn-primary rp-ok">保存</button>
  </div>
</div>

<section class="box" id="box-index">
  <header>概述</header>
  <div>
    账户类型：<?= $uiUserType[$rsU->type] ?><br />
    到期时间：<span title="<?= gmdate("Y.m.d H:i:s",$rsU->expired);?>"><?= lpTools::niceTime($rsU->expired);?></span><br />
    <a class="btn btn-success" href="/pay/"> 续费</a>
  <div>
</section>

<section class="box" id="box-account">
  <header>账户</header>
  <div>
    <input type="text" class="input-xxlarge" id="sshpasswd" name="sshpasswd" />
    <button class="btn btn-success" onclick="changePasswd('sshpasswd',false);">修改SSH密码</button>
  <div>
  <div>
    <input type="text" class="input-xxlarge" id="mysqlpasswd" name="mysqlpasswd" />
    <button class="btn btn-success" onclick="changePasswd('mysqlpasswd',false);">修改MySQL密码</button>
  <div>
  <div>
    <input type="text" class="input-xxlarge" id="panelpasswd" name="panelpasswd" />
    <button class="btn btn-success" onclick="changePasswd('panelpasswd',true);">修改面板(即该网页)密码</button>
  <div>
    <div>
    <input type="text" class="input-xxlarge" id="pptppasswd" name="pptppasswd" />
    <button class="btn btn-success" onclick="changePasswd('pptppasswd',true);">修改PPTP VPN密码</button>
  <div>
</section>

<section class="box" id="box-website">
<header>Web站点管理</header>
<? while($rs->read()): ?>
  <div class="box website" id="website<?= $rs->id;?>">
    <div>站点ID：<span class="label"><?= $rs->id;?></span></div>
    <hr />
    <div>
      绑定的域名：
      <?php 
        $domains=explode(" ",trim(str_replace("  "," ",$rs->domains)));
        foreach($domains as $v)
        {
          echo "<span class='label'>{$v}</span>  ";
        }
      ?>
    </div>
    <hr />
    <div class="box">
      <header>模板：<?= $uiTemplate[$rs->template];?></header>
      <? switch($rs->template): 
        case "web": ?>
          <div><i class="icon-ok"></i><?= $uiType[$rs->type];?></div>
          <div>
          <? switch($rs->type):
            case "all":
            break; ?>
            <? case "only": ?>
              PHP: <?= $rs->php;?><br />
              CGI: <?= $rs->cgi;?><br />
              <i class="<?= ($rs->is404)?"icon-ok":"icon-remove";?>"></i>转发不存在的路径(404)
            <? break;
            case "unless": ?>
              静态文件: <?= $rs->static;?>
          <? endswitch; ?>
          </div>
          <hr />
          <div>
            默认首页：<?= $rs->indexs;?><br />
            <i class="<?= ($rs->autoindex)?"icon-ok":"icon-remove";?>"></i>自动索引页面
          </div>
          <hr />
        <? break;
        case "proxy":
        break;
        case "python": ?>
          <div>
            默认首页：<?= $rs->indexs;?><br />
            <i class="<?= ($rs->autoindex)?"icon-ok":"icon-remove";?>"></i>自动索引页面
          </div>
          <hr />
      <? endswitch; ?>
      <div>
        <?= $uiHander[$rs->template];?>：<?= $rs->root;?></span>
      </div>
    </div>
    <hr />
    <div>
      Alias别名：
      <?php
        $alias=json_decode($rs->alias,true);
        foreach($alias as $k => $v)
        {
            echo "$k : $v";
        }
      ?>
    </div>
    <hr />
    <div>
      nginx access日志：<?= $rs->nginxaccess;?><br />
      nginx error日志：<?= $rs->nginxerror;?><br />
      apache access日志：<?= $rs->apacheaccess;?><br />
      apache error日志：<?= $rs->apacheerror;?>
    </div>
    <hr />
    <div>
      <i class="<?= ($rs->isssl)?"icon-ok":"icon-remove";?>"></i>SSL<br />
      key：<?= $rs->sslkey;?><br />
      crt：<?= $rs->sslcrt;?>
    </div>
    <hr />
    <button class="btn btn-danger pull-right" onclick="deleteWebsite(<?= $rs->id;?>);return false;">删除</button>
    <button class="btn btn-info pull-right" style="margin-right:10px;" onclick="editWebsite(<?= $rs->id;?>);return false;">编辑</button>
  </div>
<? endwhile; ?>
  <div class="box website">
    <button id="new-website" class="btn btn-success pull-right">添加站点</button>
  </div>
</section>

<section class="box" id="box-log">
    <header>日志</header>
    <div>
        <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>id</th><th>时间</th><th>内容</th>
          </tr>
        </thead>
        <tbody>
          <? while($rsL->read()): ?>
            <tr>
              <td><?= $rsL->id;?></td><td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= $rsL->content;?></td>
            </tr> 
          <? endwhile; ?>
        </tbody>
      </table>
    <div>
</section>
  
<?php

$tmp->output();

?>
