<?php

namespace App\Http\Service;


use App\User;
use GuzzleHttp\Client;

class UserService {

    /**
     * 添加用户信息
     * @param $userInfo
     * @return mixed
     */
    public function addUser($userInfo)
    {
        return User::insertGetId($userInfo,'user_id');
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

    /**
     * 通过手机查找用户
     * @param $phone
     * @return array
     */
    public function fundUserByPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            return $user;
        }
        return $user->toArray();
    }
}