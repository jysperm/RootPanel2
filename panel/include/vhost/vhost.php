<?php

global $rpVHostType, $rpROOT;

$rpVHostType = [];

$types = [
    "phpfpm", "proxy", "apache2", "nginx", "uwsgi"
];

foreach($types as $type)
    require_once("{$rpROOT}/include/vhost/{$type}.php");
