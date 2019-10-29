<?php

namespace App\Http\Controllers;

use App\Http\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户信息
     * @param UserService $userService
     * @param $openid
     * @return JsonResponse
     */
    public function userInfo(UserService $userService, $openid)
    {
        $user = $userService->fundUserByOpenId($openid);

        return response()->json($user);
    }
}
