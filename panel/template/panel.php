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
    
  }
</script>

<?php
$a["endOfBody"]=lpEndBlock();

?>

<section class="box" id="box-website">
  <header>Web站点管理</header>
  <div class="box website">
    <div>
      站点ID：123456 | 模板：常规Web
    </div>
    <hr />
    <div>
      绑定的域名：test.rphost1.tk *.test.rphost.tk
    </div>
    <hr />
    <div>
      网站根目录：/home/test/web/
    </div>
    <hr />
    <div>
      仅将指定的URL转发给Apache作为动态脚本处理<br />
      <i class="icon-ok"></i>PHP: .php<br />
      <i class="icon-ok"></i>CGI: .cgi<br />
      <i class="icon-ok"></i>不存在的路径<br />
    </div>
    <hr />
    <div>
      默认首页：index.html index.php<br />
      已开启自动索引页面
    </div>
    <hr />
    <div>
      Alias别名：
    </div>
    <hr />
    <div>
      nginx access日志：<br />
      nginx error日志：<br />
      apache access日志：<br />
      apache error日志：
    </div>
    <hr />
    <div>
      已开启SSL<br />
      key：<br />
      crt：
    </div>
    <hr />
    <button class="btn btn-danger pull-right">删除</button>
    
    <button class="btn btn-info pull-right" style="margin-right:10px;" onclick="editWebsite(123456);return false;">编辑</button>
  </div>
  
  <div class="box website">
    <div>
      站点ID：123456 | 模板：常规Web
    </div>
    <hr />
    <div>
      绑定的域名：test.rphost1.tk *.test.rphost.tk
    </div>
    <hr />
    <div>
      网站根目录：/home/test/web/
    </div>
    <hr />
    <div>
      仅将指定的URL转发给Apache作为动态脚本处理<br />
      <i class="icon-ok"></i>PHP: .php<br />
      <i class="icon-ok"></i>CGI: .cgi<br />
      <i class="icon-ok"></i>不存在的路径<br />
    </div>
    <hr />
    <div>
      默认首页：index.html index.php<br />
      已开启自动索引页面
    </div>
    <hr />
    <div>
      Alias别名：
    </div>
    <hr />
    <div>
      nginx access日志：<br />
      nginx error日志：<br />
      apache access日志：<br />
      apache error日志：
    </div>
    <hr />
    <div>
      已开启SSL<br />
      key：<br />
      crt：
    </div>
    <hr />
    <button class="btn btn-danger pull-right">删除</button>
    
    <button class="btn btn-info pull-right" style="margin-right:10px;">编辑</button>
  </div>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>
