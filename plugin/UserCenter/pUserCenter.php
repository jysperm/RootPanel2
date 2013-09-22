<?php

class pUserCenter extends lpPlugin
{
    protected static function metaData()
    {
        return parent::meta([
            "name" => "UserCenter",
            "version" => ["1.0" => 1],
            "type" => ["export"],
            "requestStatic" => [
                "bootstrap", "jquery"
            ]
        ]);
    }

    protected function init()
    {
        $this->load("model/pUserModel");
    }
}