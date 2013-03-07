<?php

global $rpROOT, $msg, $rpCfg, $lpApp, $rpVHostType, $rpVHostType;

require_once("{$rpROOT}/handler/vhost-types.php");

$tmp = new lpTemplate("{$rpROOT}/template/base.php");
$tmp->title = "控制面板主页";

$q = new lpDBQuery($lpApp->getDB());
$user = $q("user")->where(["uname" => $lpApp->auth()->getUName()])->top();
$logs = $q("log")->where(["uname" => $lpApp->auth()->getUName()])->limit(30)->select();
$hosts = $q("virtualhost")->where(["uname" => $lpApp->auth()->getUName()])->limit(30)->select();

?>

<? lpTemplate::beginBlock();?>
    <li class="active"><a href="#section-index"><i class="icon-chevron-right"></i> 概述</a></li>
    <li><a href="#section-account"><i class="icon-chevron-right"></i> 账户</a></li>
    <li><a href="#section-website"><i class="icon-chevron-right"></i> Web站点管理</a></li>
    <li><a href="#section-log"><i class="icon-chevron-right"></i> 日志摘要</a></li>
    <li><a href="/panel/logs/"><i class="icon-share"></i> 详细日志</a></li>
<? $tmp->sidenav = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
  .input-xxlarge {
    width: 250px;
  }
  #section-account button {
    margin-bottom: 10px;
  }
  .box {
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin-bottom: 20px;
    -webkit-box-shadow: 0 0 0 1px #DDD;
    -moz-box-shadow: 0 0 0 1px #ddd;
    box-shadow: 0 0 0 1px #DDD;
    overflow: hidden;
    padding: 14px;
  }
<? $tmp->css = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock();?>
<script type='text/javascript' src='/script/panel.js'></script>

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

<? $tmp->endOfBody = lpTemplate::endBlock();?>

<div class="modal hide" id="editWebsite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="dialog-title"></h3>
  </div>
  <div class="modal-body dialog-body">
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button class="btn btn-primary dialog-ok">保存</button>
  </div>
</div>

<section id="section-index">
  <header>概述</header>
  <p>
    账户类型：<?= $msg["uiUserType"][$user["type"]] ?><br />
    到期时间：<span title="<?= gmdate("Y.m.d H:i:s", $user["expired"]);?>"><?= rpTools::niceTime($user["expired"]);?></span>
    <a class="btn btn-success" href="/pay/"> 续费</a>
  </p>
</section>

<section id="section-account">
  <header>账户</header>
  <div>
    <input type="text" class="input-xxlarge" id="sshpasswd" name="sshpasswd" />
    <button class="btn btn-success" onclick="changePasswd('sshpasswd',false);">修改SSH/SFTP密码</button>
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
    <button class="btn btn-success" onclick="changePasswd('pptppasswd',false);">修改PPTP VPN密码</button>
  <div>
  <hr />
  <div>
    <a href="#" rel="tooltip" title="<?= $msg["extconfHelp"];?>">额外</a>的Nginx配置文件： 0字节(<a href="#">查看</a>).<br />
    额外的Apache2配置文件： 0字节(<a href="#">查看</a>).
  </div>
</section>

<section id="section-website">
<header>Web站点管理</header>
  <p>

  </p>
  <? while($hosts->read()): ?>
    <div class="box">
      <div>
        <a href="#" rel="tooltip" title="<?= $msg["isonHelp"];?>">是否开启</a>：<span class="label"><?= $hosts["ison"]?"是":"否";?></span> |
        <a href="#" rel="tooltip" title="<?= $msg["idHelp"];?>">站点ID</a>：<span class="label"><?= $hosts["id"];?></span> |
        <a href="#" rel="tooltip" title="<?= $msg["domainHelp"];?>">域名</a>：<span class="label"><?= $hosts["domains"];?></span>
      </div>
      <div>
        <a href="#" rel="tooltip" title="<?= $msg["typeHelp"];?>">站点类型</a>：<span class="label"><?= $rpVHostType[$hosts["type"]]["name"];?></span> |
        <a href="#" rel="tooltip" title="<?= $msg["sourceHelp"];?>">数据源</a>： <span class="label"><?= $hosts["source"];?></span>
      </div>
      <button class="btn btn-danger pull-right" onclick="deleteWebsite(<?= $hosts["id"];?>);return false;">删除</button>
      <button class="btn btn-info pull-right" style="margin-right:10px;" onclick="editWebsite(<?= $hosts["id"];?>);return false;">修改</button>
    </div>
  <? endwhile; ?>
  <div class="box">
    <button id="new-website" class="btn btn-success pull-right">添加站点</button>
  </div>
</section>

<section id="section-log">
    <header>日志</header>
    <p>以下为最新30条的摘要 (<a href="/panel/logs/">详细日志</a>).</p>
    <div>
        <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>id</th><th>时间</th><th>摘要</th>
          </tr>
        </thead>
        <tbody>
          <? while($logs->read()): ?>
            <tr>
              <td><?= $logs["id"];?></td>
              <td><span title="<?= gmdate("Y.m.d H:i:s", $logs["time"]);?>"><?= rpTools::niceTime($logs["time"]);?></span></td>
              <td><?= htmlentities($logs["description"]);?></td>
            </tr> 
          <? endwhile; ?>
        </tbody>
      </table>
    <div>
</section>
  
<? $tmp->output();?>
