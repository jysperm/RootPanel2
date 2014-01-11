<?php

namespace RootPanel\Core\Model;

use RootPanel\Core\Core\Model;

class UserModel extends Model
{
    public function checkPasswd($passwd)
    {
        return $this->data["passwd"] == self::hashPasswd($this->data["username"], $passwd);
    }

    /**
     * @param $username
     * @return UserModel
     */
    public static function byUsername($username)
    {
        return static::by("username", $username);
    }

    /**
     * @param $email
     * @return UserModel
     */
    public static function byEmail($email)
    {
        return static::by("email", $email);
    }

    public static function register($username, $passwd, $email, $contact)
    {
        return self::q()->insert([
            "username" => $username,
            "passwd" => static::hashPasswd($username, $passwd),
            "email" => $email,
            "contacts" => ["default" => $contact],
            "settings" => [],
            "group" => ["account" => "off"],
            "signup_at" => time()
        ]);
    }

    public static function hashPasswd($username, $passwd)
    {
        return hash("sha256", hash("sha256", $username) . hash("sha256", $passwd));
    }

    public static function getTokenModel()
    {
        return new TokenModel;
    }
}