<?php

global $rpROOT, $rpL, $rpCfg;
lpLocale::i()->load(["node-list"]);

?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th><?= $rpL["nodelist.location"]; ?></th>
        <th>
            <a href="#" rel="popover" data-content="<?= $rpL["nodelist.popover.minRes"]; ?>"
               data-original-title="<?= $rpL["nodelist.minGuarantee"]; ?>"><?= $rpL["nodelist.min"]; ?></a><?= $rpL["nodelist.MemoryGuarantee"]; ?>
        </th>
        <th><?= $rpL["nodelist.minCPUGuarantee"]; ?></th>
        <th><?= $rpL["nodelist.disk"]; ?></th>
        <th><?= $rpL["nodelist.trafficPerMonth"]; ?></th>
        <th><?= $rpL["nodelist.domain"]; ?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($rpCfg["NodeList"] as $nodeID => $node): ?>
        <tr>
            <td><a href="#" rel="popover" data-content="<?= $node["description"]; ?>"
                   data-original-title="<?= $node["name"]; ?>"><?= $node["name"]; ?></a></td>
            <td><?= $node["memory"]; ?>M</td>
            <td><?= $node["cpu"]; ?>MHz</td>
            <td><?= $node["disk"]; ?>M</td>
            <td><?= $node["traffic"]; ?>G</td>
            <td><a href="http://<?= $node["domain"]; ?>/"><?= $node["domain"]; ?></a></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
