<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load("node-list");

?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th><?= l("node-list.location"); ?></th>
        <th>
            <a href="#" rel="popover" data-content="<?= l("node-list.popover.minRes"); ?>"
               data-original-title="<?= l("node-list.minGuarantee"); ?>"><?= l("node-list.min"); ?></a><?= l("node-list.MemoryGuarantee"); ?>
        </th>
        <th><?= l("node-list.disk"); ?></th>
        <th><?= l("node-list.trafficPerMonth"); ?></th>
        <th><?= l("node-list.domain"); ?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach(c("NodeList") as $nodeID => $node): ?>
        <tr>
            <td><a href="#" rel="popover" data-content="<?= l("node-list")[$nodeID]["description"]; ?>"
                   data-original-title="<?= l("node-list")[$nodeID]["name"]; ?>"><?= l("node-list")[$nodeID]["name"]; ?></a></td>
            <td><?= $node["memory"]; ?>M</td>
            <td><?= $node["disk"]; ?>M</td>
            <td><?= $node["traffic"]; ?>G</td>
            <td><a href="http://<?= $node["domain"]; ?>/"><?= $node["domain"]; ?></a></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
