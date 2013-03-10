<?php

global $rpROOT, $rpCfg, $msg, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = $titile = "详细日志 #{$page}";

$allPage = ceil(rpApp::q("log")->where(["uname" => rpAuth::uname()])->select()->num() / $rpCfg["LogPerPage"]);
$logs = rpApp::q("log")->where(["uname" => rpAuth::uname()])->sort("time", false)->limit($rpCfg["LogPerPage"])->skip(($page-1) * $rpCfg["LogPerPage"])->select();
?>

<? lpTemplate::beginBlock();?>
<style type="text/css">
  table {
    table-layout:fixed;
    word-break:break-all;
  }
</style>
<? $base->header = lpTemplate::endBlock();?>

<section>
  <a href="/panel" style="margin-top: 30px;" class="btn btn-info pull-right">返回面板</a>
  <header>详细日志 <span class="text-small-per50 not-bold">#<?= $page;?> (共<?= $allPage;?>)</span></header>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
      <th style="width: 40px;"><a href="#" rel="tooltip" title="<?= $msg["logidHelp"];?>">ID</a></th>
      <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $msg["byHelp"];?>">操作者</a></th>
      <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $msg["ipuaHelp"];?>">IP/UA</a></th>
      <th style="width: 60px;">时间</th>
      <th style="width: 100px;">摘要</th>
      <th>详情</th>
    </tr>
    </thead>
    <tbody>
    <? while($logs->read()): ?>
    <tr>
      <td><?= $logs["id"];?></td>
      <td><?= $logs["by"];?></td>
      <td><span title="<?= htmlentities($logs["ua"]);?>"><?= $logs["ip"];?></span></td>
      <td><span title="<?= gmdate("Y.m.d H:i:s", $logs["time"]);?>"><?= rpTools::niceTime($logs["time"]);?></span></td>
      <? $args = json_decode($logs["info"]);
        array_unshift($args, $rpL[$logs["type"]]);
        ?>
      <td><?= htmlentities(call_user_func_array("sprintf", $args));?></td>
      <td><?= nl2br(htmlentities($logs["detail"]));?></td>
    </tr>
        <? endwhile; ?>
    </tbody>
  </table>
  <div class="pagination pagination-centered">
    <ul>
        <? for($i=$page-3 ; $i<$page ; $i++): ?>
        <? if($i > 0): ?>
        <li><a href="/panel/logs/<?= $i;?>/"><?= $i;?></a></li>
            <? endif;?>
        <? endfor;?>
      <li class="active"><a href="#"><?= $page;?></a></li>
        <? for($i=$page+1 ; $i<=$page+3 ; $i++): ?>
        <? if($i <= $allPage): ?>
        <li><a href="/panel/logs/<?= $i;?>/"><?= $i;?></a></li>
            <? endif;?>
        <? endfor;?>
    </ul>
  </div>
</section>

<? $base->output();?>
