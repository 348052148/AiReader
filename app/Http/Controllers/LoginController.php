<?php

namespace App\Http\Controllers;


use App\Http\Service\UserService;
use App\Http\Service\WeChatService;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * 登陆
     * @param Request $request
     * @param WeChatService $weChatService
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request, WeChatService $weChatService, UserService $userService, $code)
    {
        $weInfo = $weChatService->getOpenid($code);
        $userInfo = $userService->fundUserByOpenId($weInfo['openid']);

        if (!$userInfo) {
            return response()->json([
               'code' => 404,
               'msg' => 'find empty'
            ]);
        }

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'data' => $userInfo
        ]);
    }

    /**
     * 注册信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, UserService $userService)
    {
        $userInfo = $request->input('data');

        $result = $userService->addUser([
            'openid' => $request->input('openid'),
            'city' => $userInfo['city'],
            'avatar_url' => $userInfo['avatarUrl'],
            'country' => $userInfo['country'],
            'gender' => $userInfo['gender'],
            'language' => $userInfo['language'],
            'nick_name' => $userInfo['nickName'],
            'province' => $userInfo['province'],
        ]);

        if (!$result) {
            return response()->json([
                'code' => 500,
                'msg' => 'insert fail',
                'data' => []
            ]);
        }

        return response()->json([
           'code' => 0,
           'msg' => 'ok',
           'data' => []
        ]);
    }


}
