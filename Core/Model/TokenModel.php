<?php

namespace RootPanel\Core\Model;

use RootPanel\Core\Core\Model;

class TokenModel extends Model
{
    const ALIVE = "alive";
    const DELETED = "deleted";

    /**
     * @param string $token
     * @return TokenModel
     */
    public static function byToken($token)
    {
        return self::by("token", $token);
    }

    public function userID()
    {
        return $this->data["user_id"];
    }

    /**
     * 生成一个新的 Token
     *
     * @param UserModel $user
     * @return string
     */
    public static function newToken($user)
    {
        $token = null;
        do {
            $token = sha1(rand(0, PHP_INT_MAX));
        } while (self::byToken($token)->data());

        self::q()->insert([
            "user_id" => $user->id(),
            "token" => $token
        ]);

        return $token;
    }

    public function isValid($expiredTime)
    {
        return time() - $this->data["accessed_at"] < $expiredTime;
    }

    public function remove()
    {
        $this->update([
            "status" => self::DELETED
        ]);

    }

    public function renew()
    {
        $this->update([
            "accessed_at" => time()
        ]);
    }
}