<?php

$v = $this["hosts"];

$exts = str_replace(" ", "|", $v["settings"]["extension"]);

?>

root <?= $v["source"];?>;

<? if($v["settings"]["type"] == "only"): ?>
    location / {
        try_files $uri $uri/ @apache;
    }

    location ~ \.(<?= $exts;?>)$ {
        proxy_pass http://127.0.0.1:8080;
    }

    location @apache {
        proxy_pass http://127.0.0.1:8080;
    }
<? else:?>
    location / {
        proxy_pass http://127.0.0.1:8080;
    }

    location ~ \.(<?= $exts;?>)$ {
        try_files $uri =404;
    }
<? endif;?>

location = / {
    proxy_pass http://127.0.0.1:8080;
}

