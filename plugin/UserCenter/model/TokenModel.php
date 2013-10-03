<?php

namespace lpPlugins\UserCenter;

class TokenModel extends \lpPDOModel
{
    protected static function metaData($data = null)
    {
        return parent::meta([
            "table" => "token",
            "struct" => [
                "id" => [self::INT, self::AI],
                "user_id" => [self::INT],
                "token" => [self::VARCHAR => 40],
                "accesse_at" => [self::UINT, self::DEFALT => 0],
                // TODO: ENUM 类型
                "status" => [self::VARCHAR => 255, self::DEFALT => self::ALIVE],
                "settings" => [self::TEXT, self::JSON]
            ]
        ]);
    }

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
     * 生成一个新的 Toekn
     *
     * @param UserModel $user
     * @return string
     */
    public static function newToken($user)
    {
        $token = null;
        do {
            $token = sha1(rand(0, PHP_INT_MAX));
        } while(self::byToken($token)->data());

        self::insert([
            "user_id" => $user->id(),
            "token" => $token
        ]);

        return $token;
    }

    public function isValid($expiredTime)
    {
        return time() - $this->data["accesse_at"] < $expiredTime;
    }

    public function remove()
    {
        $this->updateSelf([
            "status" => self::DELETED
        ]);

    }

    public function renew()
    {
        $this->updateSelf([
            "accesse_at" => time()
        ]);
    }
}