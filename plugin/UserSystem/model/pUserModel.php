<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class pUserModel extends lpPDOModel
{
    protected static function metaData($data = null)
    {
        return parent::meta([
            "table" => "user",
            "struct" => [
                "id" => [self::INT, self::AI, self::PRIMARY],
                "uname" => [self::VARCHAR => 256],
                "passwd" => [self::TEXT],
                "email" => [self::TEXT],
                "contacts" => [self::TEXT, self::JSON],
                "settings" => [self::TEXT, self::JSON],
                "signup_at" => [self::UINT],
                "group" => [self::TEXT, self::JSON]
            ]
        ]);
    }
}