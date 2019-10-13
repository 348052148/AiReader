<?php

namespace App\Http\Service;


use App\User;
use GuzzleHttp\Client;

class UserService {
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 添加用户信息
     * @param $userInfo
     * @return mixed
     */
    public function addUser($userInfo)
    {
        return User::insert($userInfo);
    }

    /**
     * 通过openid获取用户信息
     * @param $openid
     * @return mixed
     */
    public function fundUserByOpenId($openid)
    {
        $user = User::where('openid', $openid)->first();
        if (!$user) {
            return $user;
        }

        return $user->toArray();
    }
}