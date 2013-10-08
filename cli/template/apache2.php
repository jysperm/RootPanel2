<?php

$v = $this["hosts"];

?>
<VirtualHost *:8080>

    ServerName <?= $this["uname"]; ?><?= $v["id"]; ?>

    ServerAlias <?= $v["domains"]; ?>

    DirectoryIndex <?= $v["general"]["indexs"]; ?>

    Options <?= $v["general"]["autoindex"] ? "+" : "-"; ?>Indexes

    DocumentRoot <?= $v["source"]; ?>

    <? foreach($v["general"]["alias"] as $k => $v): ?>
        Alias <?= $k;?> <?= $v;?>

    <? endforeach; ?>

    ErrorLog /home/<?= $this["uname"];?>/apache2.access.log

    LogLevel warn

    CustomLog /home/<?= $this["uname"];?>/apache2.access.log vhost_combined

    AssignUserId <?= $this["uname"];?> <?= $this["uname"];?>

</VirtualHost>

