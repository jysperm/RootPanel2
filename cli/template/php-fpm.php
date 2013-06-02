<?php
$u = $this["uname"];
?>
[<?= $u;?>]

user = <?= $u;?>
group = <?= $u;?>

listen = /tmp/<?= $u;?>-fpm.sock
listen.owner = <?= $u;?>
listen.group = <?= $u;?>
listen.mode = 0666

pm = dynamic
pm.max_children = 10
pm.start_servers = 3
pm.min_spare_servers = 1
pm.max_spare_servers = 3