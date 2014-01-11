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

    "EnablePlugin" => [

    ],

    "DefaultLanguage" => "zh_CN",
    "AvailableLanguage" => ["zh_CN"],

    // TODO: 此处应自动检查 /etc/passwd
    "NotAllowSignup" => [
        "root", "default", "admin", "sudo"
    ]
];