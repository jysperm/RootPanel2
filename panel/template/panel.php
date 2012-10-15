<?php

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
        $("#editWebsite").modal();
      },"html");
  }
</script>

<?php
$a["endOfBody"]=lpEndBlock();

$uiTemplate=array("web"=>"常规Web(PHP等CGI)",
                  "proxy"=>"反向代理",
                  "python"=>"Python(WSGI模式)");
$uiHander=array("web"=>"Web根目录",
                "proxy"=>"反向代理URL",
                "python"=>"Web根目录");
$uiType=array("all"=>"全部转到Apache",
              "only"=>"仅转发指定的URL(一般是脚本文件)",
              "unless"=>"不转发指定的URL(一般是静态文件)");

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
        <? break;
        case "proxy":
        break;
        case "python": ?>
          <div>
            默认首页：<?= $rs->indexs;?><br />
            <i class="<?= ($rs->autoindex)?"icon-ok":"icon-remove";?>"></i>已开启自动索引页面
          </div>
      <? endswitch; ?>
      <hr />
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
  <div class="box website">
    <button class="btn btn-success pull-right" onclick="addWebsite();return false;">添加站点</button>
  </div>
<? endwhile; ?>
</section>
  
<?php

$tmp->parse("template/base.php",$a);

?>
