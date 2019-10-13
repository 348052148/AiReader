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
     * @OA\Get(path="/api/wechat/{code}",
     *   operationId="微信小程序登陆",
     *   @OA\Parameter(
     *     name="code",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="成功"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="没有找到用户"
     *   ),
     *   @OA\RequestBody(
     *      description="Updated user object",
     *      required=true,
     *   )
     * )
     */
    public function login(Request $request, WeChatService $weChatService, UserService $userService, $code)
    {
        $weInfo = $weChatService->getOpenid($code);
        $userInfo = $userService->fundUserByOpenId($weInfo['openid']);

        if (!$userInfo) {
            return response()->json([
               'msg' => 'find empty'
            ], 404);
        }

        return response()->json($userInfo);
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
                'msg' => 'insert fail',
            ], 500);
        }

        return response()->json([]);
    }


}
