<?php

$v = $this["hosts"];

?>
root <?= $v["source"];?>;

location / {
    try_files $uri $uri/ /index.php?$args;
}

location ~ \.php$ {
    <? if($v["settings"]["server"]):?>
        fastcgi_pass unix:<?= $v["settings"]["server"];?>;
    <? else:?>
        fastcgi_pass unix:/tmp/<?= $this["uname"];?>-fpm.sock;
    <? endif;?>

    fastcgi_index index.php;
    include fastcgi_params;
}