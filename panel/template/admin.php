<?php

global $uiTemplate,$uiHander,$uiType,$uiUserType;

$tmp = new lpTemplate;

$a["mainClass"] = "main50";
$a["title"] = "管理员面板";

lpBeginBlock();?>


<?php
$a["header"]=lpEndBlock();

lpBeginBlock();?>

<li><a href="#box-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#box-users"><i class="icon-chevron-right"></i> 用户管理</a></li>
<li><a href="#box-log"><i class="icon-chevron-right"></i> 日志</a></li>

<?php
$a["rpSidebar"]=lpEndBlock();

lpBeginBlock();?>

<script type="text/javascript">
  
</script>

<?php
$a["endOfBody"]=lpEndBlock();

$conn=new lpMySQL;
$rsL=$conn->select("log",array(),"time",-1,100,false);

?>

<section class="box" id="box-index">
    <header>概述</header>
</section>

<section class="box" id="box-user">
    <header>用户管理</header>
</section>


<section class="box" id="box-log">
    <header>日志</header>
    <div>
        <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>id</th><th>用户</th><th>时间</th><th>内容</th>
          </tr>
        </thead>
        <tbody>
          <? while($rsL->read()): ?>
            <tr>
              <td><?= $rsL->id;?></td><td><?= $rsL->uname;?></td><td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= $rsL->content;?></td>
            </tr> 
          <? endwhile; ?>
        </tbody>
      </table>
    <div>
</section>
  
<?php

$tmp->parse("template/base.php",$a);

?>
