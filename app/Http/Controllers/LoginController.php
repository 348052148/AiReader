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
    public function loginByWeChat(WeChatService $weChatService, UserService $userService, $code)
    {
        $weInfo = $weChatService->getOpenid($code);
        $userInfo = $userService->fundUserByOpenId($weInfo['openid']);

        if (!$userInfo) {
            return response()->json([
                'openid' => $weInfo['openid'],
                'msg' => 'find empty'
            ], 404);
        }

        return response()->json($userInfo);
    }

    /**
     * 微信注册信息
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerByWeChat(Request $request, UserService $userService)
    {
        $userInfo = $request->input('data');

        $userData = [
            'openid' => $request->input('openid'),
            'city' => $userInfo['city'],
            'avatar_url' => $userInfo['avatarUrl'],
            'country' => $userInfo['country'],
            'gender' => $userInfo['gender'],
            'language' => $userInfo['language'],
            'nick_name' => $userInfo['nickName'],
            'province' => $userInfo['province'],
            'phone' => '',
        ];
        $result = $userService->addUser($userData);

        if (!$result) {
            return response()->json([
                'msg' => 'insert fail',
            ], 500);
        }

        return response()->json($userData);
    }

    /**
     * 账户密码登陆
     * @param Request $request
     * @param UserService $userService
     * @param string $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, UserService $userService, string $account)
    {
        $code = $request->input('code');
        $password = $request->input('password');
        $user = $userService->fundUserByPhone($account);
        if (!$user) {
            return response()->json(['msg' => 'user not fund'], 404);
        }
        if ($password != $user['password']) {
            return response()->json(['msg' => 'password error or account error'], 400);
        }

        return response()->json($user);
    }

    /**
     * 账户密码注册
     * @param Request $request
     * @param UserService $userService
     * @param string $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, UserService $userService, string $account)
    {
        $password = $request->input('password');
        $code = $request->input('code');
        $userData = [
            'openid' => '',
            'city' => '',
            'avatar_url' => '',
            'country' => '',
            'gender' => '',
            'language' => '',
            'nick_name' => '',
            'province' => '',
            'phone' => $account,
            'password' => md5($password)
        ];
        $result = $userService->addUser($userData);
        if (!$result) {
            return response()->json([
                'msg' => 'insert fail',
            ], 500);
        }
        return response()->json($userData);
    }

    /**
     * 手机号验证码登陆
     * @param Request $request
     * @param UserService $userService
     * @param string $phone
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByPhoneValidCode(Request $request, UserService $userService, string $phone)
    {
        $code = $request->input('code');
        $user = $userService->fundUserByOpenId($phone);
        if (!$user) {
            $userData = [
                'openid' => '',
                'city' => '',
                'avatar_url' => '',
                'country' => '',
                'gender' => '',
                'language' => '',
                'nick_name' => '',
                'province' => '',
                'phone' => $phone,
            ];
            $result = $userService->addUser($userData);
            if (!$result) {
                return response()->json([
                    'msg' => 'insert fail',
                ], 500);
            }
            return response()->json($userData);
        }
        return response()->json($user);
    }

}
