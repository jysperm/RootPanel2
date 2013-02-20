<?php

global $rpROOT, $rpCfg, $lpApp, $rpM;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");
$tmp->title = $titile = "详细日志 #{$page}";

$q = new lpDBQuery($lpApp->getDB());
$allPage = ceil($q("log")->where(["uname" => $lpApp->auth()->getUName()])->select()->num() / $rpCfg["LogPerPage"]);
$logs = $q("log")->where(["uname" => $lpApp->auth()->getUName()])->sort("time", false)->limit($rpCfg["LogPerPage"])->skip(($page-1) * $rpCfg["LogPerPage"])->select();
?>

<? lpTemplate::beginBlock();?>
  table {
    table-layout:fixed;
    word-break:break-all;
  }
<? $tmp->css = lpTemplate::endBlock();?>

<section>
  <a href="/panel/" style="margin-top: 30px;" class="btn btn-info pull-right">返回面板</a>
  <header>详细日志 <span class="text-small-per50 not-bold">#<?= $page;?> (共<?= $allPage;?>)</span></header>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
      <th style="width: 40px;"><a href="#" rel="tooltip" title="<?= $rpM["logidHelp"];?>">ID</a></th>
      <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $rpM["byHelp"];?>">操作者</a></th>
      <th style="width: 70px;"><a href="#" rel="tooltip" title="<?= $rpM["ipuaHelp"];?>">IP/UA</a></th>
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
      <td><?= htmlentities($logs["description"]);?></td>
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

<? $tmp->output();?>
