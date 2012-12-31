<?php if(!isset($lpInTemplate)) die();

global $rpROOT,$conn,$uiTemplate,$uiHander,$uiType,$uiUserType,$lpCfgTimeToChina;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->mainClass = "main50";
$tmp->title = "管理员面板";

lpTemplate::beginBlock();?>


<?php
$tmp->header=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<li><a href="#box-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#box-users"><i class="icon-chevron-right"></i> 用户管理</a></li>
<li><a href="#box-log"><i class="icon-chevron-right"></i> 日志</a></li>

<?php
$tmp->rpSidebar=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<script type="text/javascript">
  function userAddTime(uname)
  {
    $.post("/commit/admin/",{"do":"addtime","uname":uname,"day":prompt("请输入要延时的天数")},function(data){
      if(data.status=="ok")
          window.location.reload();
      else
          alert(data.msg);
    },"json");
    return false;
  }
  
  function userLog(uname)
  {
    $.post("/commit/admin/",{"do":"getlog","uname":uname},function(data){
      $("#logView .rp-title").html(uname);
      $("#logView .rp-body").html(data);
      $("#logView").modal();
    },"html");
    return false;
  }
  
  function userDelete(uname)
  {
    if(confirm("你确定要删除？"))
    {
      $.post("/commit/admin/",{"do":"delete","uname":uname},function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
      },"json");
    }
    return false;
  }
  
  function commonAct(act,uname,isReload)
  {
    $.post("/commit/admin/",{"do":act,"uname":uname},function(data){
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
$rsL=$conn->select("log",array(),"time",-1,100,false);
?>

<div class="modal hide" id="logView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><span class="rp-title"></span>的日志</h3>
  </div>
  <div class="modal-body rp-body">
    
  </div>
</div>

<section class="box" id="box-index">
    <header>概述</header>
</section>

<?php
function outputUserTable($rsU,$buttun)
{
    global $conn,$uiTemplate,$uiHander,$uiType,$uiUserType,$rpAdminUsers;
?>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th>Email(ID)</th><th>用户(UA)</th><th>注册</th><th>登录</th><th>到期</th><th>类型(站点)</th>
      </tr>
    </thead>
    <tbody>
      <? while($rsU->read()):
          if(!in_array($rsU->uname,$rpAdminUsers)):?>
        <tr>
          <td><span title="<?= $rsU->id;?>"><?= $rsU->email;?></span></td>
          <td><span title="<?= str_replace("\"","",$rsU->lastloginua) . " " . $rsU->lastloginip;?>"><?= $rsU->uname;?></span></td>
          <td><span title="<?= gmdate("Y.m.d H:i:s",$rsU->regtime);?>"><?= lpTools::niceTime($rsU->regtime);?></span></td>
          <td><span title="<?= gmdate("Y.m.d H:i:s",$rsU->lastlogintime);?>"><?= lpTools::niceTime($rsU->lastlogintime);?></span></td>
          <td>
            <span title="<?= gmdate("Y.m.d H:i:s",$rsU->expired);?>"><?= lpTools::niceTime($rsU->expired);?></span>
          </td>
          <?php
            $rsV = $conn->select("virtualhost",array("uname" => $rsU->uname));
          ?>
          <td><?= $uiUserType[$rsU->type] ?>(<?= $rsV->num();?>)</td>
        </tr>
        <tr>
          <td colspan="6">
            <button class="btn btn-success pull-right" onclick="userLog('<?= $rsU->uname;?>');">日志</button>
            <a class="btn btn-success pull-right" href="/commit/loginas/?do=loginas&uname=<?= $rsU->uname;?>&passwd=<?= lpAuth::cookieHash($rsU->passwd);?>">登录为</a>
            <button class="btn btn-success pull-right" onclick="userAddTime('<?= $rsU->uname;?>');">延时</button>
			<button class="btn btn-success pull-right" onclick="commonAct('alertpay','<!--UNAME-->',false);">续费提醒</button>
            <?= str_replace("<!--UNAME-->",$rsU->uname,$buttun);?>
          </td>
        </tr>
      <? endif;endwhile; ?>
    </tbody>
  </table>
<?php
}
?>

<section class="box" id="box-users">
  <header>用户管理</header>
  <div>
    <b>未付费用户</b>
    <?php
      $rsU=$conn->select("user",array("type"=>"no"));
        lpTemplate::beginBlock();?>
          <button class="btn btn-danger pull-right" onclick="userDelete('<!--UNAME-->',true);">删除</button>
          <button class="btn btn-success pull-right" onclick="commonAct('tofree','<!--UNAME-->',true);">转为免费试用版</button>
          <button class="btn btn-success pull-right" onclick="commonAct('toext','<!--UNAME-->',true);">转为额外技术支持版</button>
          <button class="btn btn-success pull-right" onclick="commonAct('tostd','<!--UNAME-->',true);">转为标准版</button>
        <?php
        outputUserTable($rsU,lpTemplate::endBlock());
    ?>
  </div>
  <div>
      <b>付费用户</b>
      <?php
        $rsU=$conn->exec("SELECT * FROM `user` WHERE (`type`='std' OR `type`='ext') AND `expired`>'%i'",time()+$lpCfgTimeToChina);
        outputUserTable($rsU,"");
      ?>
  </div>
  <div>
    <b>免费试用/到期用户</b>
    <?php
      $rsU=$conn->exec("SELECT * FROM `user` WHERE (`type`='free' OR `expired`<'%i') AND `type`!='no'",time()+$lpCfgTimeToChina);
          lpTemplate::beginBlock();?>
            <button class="btn btn-success pull-right" onclick="commonAct('tono','<!--UNAME-->',true);">转为未付费</button>
            <button class="btn btn-success pull-right" onclick="commonAct('alertdelete','<!--UNAME-->',false);">删除提醒</button>
          <?php
          outputUserTable($rsU,lpTemplate::endBlock());
    ?>
  </div>
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
            <td><?= $rsL->id;?></td><td><?= $rsL->uname;?></td><td><span title="<?= gmdate("Y.m.d H:i:s",$rsL->time);?>"><?= lpTools::niceTime($rsL->time);?></span></td><td><?= htmlspecialchars($rsL->content);?></td>
          </tr> 
        <? endwhile; ?>
      </tbody>
    </table>
  <div>
</section>
  
<?php

$tmp->output();

?>
