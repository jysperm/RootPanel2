<?php
$u = $this["uname"];
?>
[<?= $u; ?>]

user = <?= $u; ?>

group = <?= $u; ?>

listen = /tmp/<?= $u; ?>-fpm.sock
listen.owner = <?= $u; ?>

listen.group = <?= $u; ?>

listen.mode = 0660

pm = dynamic
pm.max_children = 30
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 2