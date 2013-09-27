<?php

namespace lpPlugins\UserCenter;


class UserCenter extends \lpPlugin
{
    protected function metaData()
    {
        return parent::meta([
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
        $this->load("handler/pUserHandler");
        $this->load("model/pUserModel");
    }

    protected function hooks()
    {
        return [
            "export.pUserCenter.UserHandler" => function() {
                return $this;
            }
        ];
    }
}