<?php

$v = $this["host"];

?>

root <?= $v["source"];?>;
location / {
    include uwsgi_params;
    uwsgi_pass unix://<?= $v["settings"]["socket"];?>;
}