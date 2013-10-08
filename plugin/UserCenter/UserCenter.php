<?php

namespace lpPlugins\UserCenter;

class UserCenter extends \lpPlugin
{
    protected function metaData()
    {
        return parent::meta([
            "dir" => dirname(__FILE__),
            "name" => "UserCenter",
            "version" => ["1.0" => 1],
            "type" => ["export"],
            "requestStatic" => [
                "bootstrap", "jquery"
            ],
            "exportHoks" => [
                "notAllowSignup"
            ]
        ]);
    }

    protected function init()
    {

    }

    protected function hooks()
    {

    }
}