<?php

global $rpROOT,$conn,$uiTemplate,$uiHander,$uiType,$uiUserType,$lpCfgTimeToChina;

$base = new lpTemplate("{$rpROOT}/template/base.php");

$base->title = "管理员面板";

?>

<?php lpTemplate::beginBlock();?>

<li><a href="#section-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#section-users"><i class="icon-chevron-right"></i> 用户管理</a></li>
<li><a href="#section-log"><i class="icon-chevron-right"></i> 日志</a></li>

<?php $base->sidenav = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript' src='/script/admin.js'></script>
<? $base->endOfBody = lpTemplate::endBlock(); ?>

<div class="modal hide" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialogLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="dialogLabel" class="dialog-title"></h3>
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
</section>

<section id="section-users">
    <header>用户管理</header>
</section>

<? $base->output(); ?>


<?php /*
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
			<button class="btn btn-success pull-right" onclick="commonAct('alertpay','<?= $rsU->uname;?>',false);">续费提醒</button>
            <?= str_replace("<!--UNAME-->",$rsU->uname,$buttun);?>
          </td>
        </tr>
      <? endif;endwhile; ?>
    </tbody>
  </table>
<?php
}
?>

<section class="box" id="section-users">
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


<section class="box" id="section-log">
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

?>*/
