<?php

return [
    "DB" => [
        "type" => "mysql",
        "host" => "localhost",
        "dbname" => "rpadmin",
        "user" => "rpadmin",
        "passwd" => "passwd",
        "charset" => "utf8"
    ],

    "Cache" => [
        "type" => "memcache",
        "host" => ["unix:///home/rpadmin/memcached.sock" => 0],
        "ttl" => 3600 * 8,
        "prefix" => "rp3:"
    ],

    "EnablePlugin" => [

    ],

    "DefaultLanguage" => "zh_CN",
    "AvailableLanguage" => ["zh_CN"],

    // TODO: should auto check /etc/passwd
    "NotAllowSignup" => [
        "root", "default", "admin", "sudo"
    ]
];