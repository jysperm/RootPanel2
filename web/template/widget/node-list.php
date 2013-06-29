<?php

/** @var lpLocale $rpL */
$rpL = f("lpLocale");
/** @var lpConfig $rpCfg */
$rpCfg = f("lpConfig");

$rpL->load("node-list");

?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th><?= $rpL["node-list.location"]; ?></th>
        <th>
            <a href="#" rel="popover" data-content="<?= $rpL["node-list.popover.minRes"]; ?>"
               data-original-title="<?= $rpL["node-list.minGuarantee"]; ?>"><?= $rpL["node-list.min"]; ?></a><?= $rpL["node-list.MemoryGuarantee"]; ?>
        </th>
        <th><?= $rpL["node-list.minCPUGuarantee"]; ?></th>
        <th><?= $rpL["node-list.disk"]; ?></th>
        <th><?= $rpL["node-list.trafficPerMonth"]; ?></th>
        <th><?= $rpL["node-list.domain"]; ?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($rpCfg["NodeList"] as $nodeID => $node): ?>
        <tr>
            <td><a href="#" rel="popover" data-content="<?= $rpL[$nodeID]["description"]; ?>"
                   data-original-title="<?= $rpL[$nodeID]["name"]; ?>"><?= $rpL[$nodeID]["name"]; ?></a></td>
            <td><?= $node["memory"]; ?>M</td>
            <td><?= $node["cpu"]; ?>MHz</td>
            <td><?= $node["disk"]; ?>M</td>
            <td><?= $node["traffic"]; ?>G</td>
            <td><a href="http://<?= $node["domain"]; ?>/"><?= $node["domain"]; ?></a></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
