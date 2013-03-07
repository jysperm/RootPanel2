<?php

global $rpROOT, $msg, $rpCfg;

?>

<table class="table table-striped table-bordered table-condensed">
  <thead>
  <tr>
    <th>机房</th><th><a href="#" rel="popover" data-content="<?= $msg['minRes'];?>" data-original-title="最小保证">最小</a>物理内存保证</th>
    <th>最小内存保证</th><th>最小CPU保证</th><th>硬盘</th><th>流量/月</th><th>域名</th>
  </tr>
  </thead>
  <tbody>
  <? foreach($rpCfg["NodeList"] as $nodeID => $node): ?>
    <tr>
      <td><a href="#" rel="popover" data-content="<?= $node["description"];?>" data-original-title="<?= $node["name"];?>"><?= $node["name"];?></a></td>
      <td><?= $node["PhyMemory"];?>M</td><td><?= $node["memory"];?>M</td><td><?= $node["cpu"] * 100;?>%</td>
      <td><?= $node["disk"];?>M</td><td><?= $node["traffic"];?>G</td><td><a href="http://<?= $node["domain"];?>/"><?= $node["domain"];?></a></td>
    </tr>
  <? endforeach; ?>
  </tbody>
</table>
