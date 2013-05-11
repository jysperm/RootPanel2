<?php

class rpNginxType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "Nginx纯静态",
            "description" => "Nginx纯静态, 不支持任何脚本"
        ];
    }

    public function settingsHTML($old)
    {
        return "";
    }

    public function defaultSettings()
    {
        return [];
    }
}