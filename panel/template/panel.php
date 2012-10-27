<?php

global $uiTemplate,$uiHander,$uiType;

$tmp = new lpTemplate;

$a["mainClass"] = "main50";
$a["title"] = "控制面板主页";

lpBeginBlock();?>


<?php
$a["header"]=lpEndBlock();

lpBeginBlock();?>

<li><a href="#box-website"><i class="icon-chevron-right"></i> Web站点管理</a></li>

<?php
$a["rpSidebar"]=lpEndBlock();

lpBeginBlock();?>

<script type="text/javascript">
  function editWebsite(websiteId)
  {
      $("#editWebsite .rp-title").html("编辑站点");
      $.post("/commit/virtualhost/",{"do":"get","id":websiteId},function(data){
        $("#editWebsite .rp-body").html(data);
        
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
        
        $("#editWebsite .rp-ok").unbind('click');
        $("#editWebsite .rp-ok").click(function(){
            postdata=$("#editWebsite .rp-form").serializeArray();
            postdata.push({name:"id",value:websiteId});
            postdata.push({name:"do",value:"edit"});
            $.post("/commit/virtualhost/", postdata,function(data){
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
    $.post("/commit/virtualhost/",{"do":"getnew"},function(data){
      $("#editWebsite .rp-body").html(data);
      
      $("#editWebsite .rp-ok").unbind('click');
      $("#editWebsite .rp-ok").click(function(){
          postdata=$("#editWebsite .rp-form").serializeArray();
          postdata.push({name:"do",value:"new"});
          $.post("/commit/virtualhost/", postdata,function(data){
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
</script>

<?php
$a["endOfBody"]=lpEndBlock();

$conn=new lpMySQL;
$rs=$conn->select("virtualhost",array("uname"=>lpAuth::getUName()));

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
              <i class="<?= ($rs->is404)?"icon-ok":"icon-remove";?>"></i>不存在的路径(404)
            <? break;
            case "unless": ?>
              静态文件: <?= $rs->static;?>
          <? endswitch; ?>
          </div>
          <hr />
          <div>
            默认首页：<?= $rs->indexs;?><br />
            <i class="<?= ($rs->autoindex)?"icon-ok":"icon-remove";?>"></i>已开启自动索引页面
          </div>
          <hr />
        <? break;
        case "proxy":
        break;
        case "python": ?>
          <div>
            默认首页：<?= $rs->indexs;?><br />
            <i class="<?= ($rs->autoindex)?"icon-ok":"icon-remove";?>"></i>已开启自动索引页面
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
      <i class="<?= ($rs->isssl)?"icon-ok":"icon-remove";?>"></i>已开启SSL<br />
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
  
<?php

$tmp->parse("template/base.php",$a);

?>
