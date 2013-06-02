<?php

$v = $this["vhost"];
$u = $this["user"];

?>

server {
    listen 80;

    <? if($v["general"]["isssl"]):?>
    listen 443 ssl;
    ssl                  on;
    ssl_certificate      <?= $v["general"]["sslcrt"]; ?>;
    ssl_certificate_key  <?= $v["general"]["sslkey"]; ?>;
    <? endif;?>

    server_name <?= $v["domains"]; ?>;

    access_log /home/<?= $u["uname"];?>/nginx.access.log;
    error_log /home/<?= $u["uname"];?>/nginx.error.log;

    index <?= $v["general"]["indexs"]; ?>;

    <?= $this["conf"];?>

    <? foreach($v["general"]["alias"] as $k => $v): ?>
    location <?= $k;?> {
        alias <?= $v;?>;
    }
    <? endforeach; ?>
}