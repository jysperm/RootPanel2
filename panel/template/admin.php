<?php

global $uiTemplate,$uiHander,$uiType,$uiUserType,$lpCfgTimeToChina;

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
  
  function userAlertPay(uname)
  {
    $.post("/commit/admin/",{"do":"alertpay","uname":uname},function(data){
        if(data.status=="ok")
            alert(data.status);
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
  function userAlertDelete(uname)
  {
    $.post("/commit/admin/",{"do":"alertdelete","uname":uname},function(data){
        if(data.status=="ok")
            alert(data.status);
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
  function userToStd(uname)
  {
    $.post("/commit/admin/",{"do":"tostd","uname":uname},function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
  function userToExt(uname)
  {
    $.post("/commit/admin/",{"do":"toext","uname":uname},function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
  function userToFree(uname)
  {
    $.post("/commit/admin/",{"do":"tofree","uname":uname},function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
  function userToNo(uname)
  {
    $.post("/commit/admin/",{"do":"tono","uname":uname},function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
    },"json");
    return false;
  }
  
</script>

<?php
$a["endOfBody"]=lpEndBlock();

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
function outputUserTable($conn,$rsU,$buttun)
{
    global $uiTemplate,$uiHander,$uiType,$uiUserType,$rpAdminUsers;
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
            <button class="btn btn-success pull-right" onclick="userLog('<?= $rsU->uname;?>');return false;">日志</button>
            <a class="btn btn-success pull-right" href="/commit/admin/?do=loginas&uname=<?= $rsU->uname;?>&passwd=<?= lpAuth::cookieHash($rsU->passwd);?>">登录为</a>
            <button class="btn btn-success pull-right" onclick="userAddTime('<?= $rsU->uname;?>');return false;">延时</button>
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
            lpBeginBlock();?>
              <button class="btn btn-danger pull-right" onclick="userDelete('<!--UNAME-->');return false;">删除</button>
              <button class="btn btn-success pull-right" onclick="userToFree('<!--UNAME-->');return false;">转为免费试用版</button>
              <button class="btn btn-success pull-right" onclick="userToExt('<!--UNAME-->');return false;">转为额外技术支持版</button>
              <button class="btn btn-success pull-right" onclick="userToStd('<!--UNAME-->');return false;">转为标准版</button>
            <?php
            outputUserTable($conn,$rsU,lpEndBlock());
        ?>
    </div>
    
    <div>
        <b>付费用户</b>
        <?php
          $rsU=$conn->exec("SELECT * FROM `user` WHERE (`type`='std' OR `type`='ext') AND `expired`>'%i'",time()+$lpCfgTimeToChina);
          outputUserTable($conn,$rsU,"");
        ?>
    </div>
    
    <div>
        <b>免费试用/到期用户</b>
        <?php
          $rsU=$conn->exec("SELECT * FROM `user` WHERE (`type`='free' OR `expired`<'%i') AND `type`!='no'",time()+$lpCfgTimeToChina);
              lpBeginBlock();?>
                <button class="btn btn-success pull-right" onclick="userToNo('<!--UNAME-->');return false;">转为未付费</button>
                <button class="btn btn-success pull-right" onclick="userAlertDelete('<!--UNAME-->');return false;">删除提醒</button>
                <button class="btn btn-success pull-right" onclick="userAlertPay('<!--UNAME-->');return false;">续费提醒</button>
              <?php
              outputUserTable($conn,$rsU,lpEndBlock());
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

$tmp->parse("template/base.php",$a);

?>
