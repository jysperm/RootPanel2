<?php

$v = $this["vhost"];

?>

location / {
    proxy_set_header Host <?= $v["settings"]["host"] ?: "\$host"; ?>;
    proxy_redirect off;
    proxy_pass <?= $v["source"];?>;
}