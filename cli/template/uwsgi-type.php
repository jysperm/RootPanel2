<?php

$v = $this["vhost"];

?>

root <?= $v["source"];?>;
location / {
    include uwsgi_params;
    uwsgi_pass unix://<?= $v["settings"]["socket"];?>;
}