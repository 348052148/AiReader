<?php

namespace App\Http\Controllers;


use App\Events\SendSMSValidCode;
use App\Http\Service\UserService;
use App\Http\Service\WeChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        $userId = $userService->addUser($userData);

        if (!$userId) {
            return response()->json([
                'msg' => 'insert fail',
            ], 500);
        }
        $userData['user_id'] = $userId;

        return response()->json($userData);
    }

    /**
     * 账户密码登陆
     * @param Request $request
     * @param UserService $userService
     * @param string $account
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request, UserService $userService, string $account)
    {
        $password = $request->input('password');
        $user = $userService->fundUserByPhone($account);
        if (!$user) {
            throw new \Exception('用户不存在', 404);
        }
        if (md5($password) != $user['password']) {
            throw new \Exception('密码错误', 400);
        }

        return response()->json($user);
    }

    /**
     * 账户密码注册
     * @param Request $request
     * @param UserService $userService
     * @param string $phoneNumber
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request, UserService $userService, string $phoneNumber)
    {
        $password = $request->input('password');
        $code = $request->input('code');

        if (!Cache::has($phoneNumber)) {
            throw new \Exception('验证码错误');
        } elseif (Cache::get($phoneNumber) != $code) {
            throw new \Exception('验证码错误');
        }

        $user = $userService->fundUserByPhone($phoneNumber);
        if ($user) {
            throw new \Exception('用户已存在');
        }

        $userData = [
            'nick_name' => '用户' . rand(pow(10, (6 - 1)), pow(10, 6) - 1),
            'phone' => $phoneNumber,
            'password' => md5($password)
        ];
        $userId = $userService->addUser($userData);
        if (!$userId) {
            throw new \Exception('注册失败');
        }
        $userData['user_id'] = $userId;
        return response()->json($userData);
    }

    /**
     * 手机号验证码登陆
     * @param Request $request
     * @param UserService $userService
     * @param string $phoneNumber
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function loginByPhoneNumberValidCode(Request $request, UserService $userService, string $phoneNumber)
    {
        $code = $request->input('code');

        if (!Cache::has($phoneNumber)) {
            throw new \Exception('验证码错误');
        } elseif (Cache::get($phoneNumber) != $code) {
            throw new \Exception('验证码错误');
        }

        $user = $userService->fundUserByPhone($phoneNumber);
        if (!$user) {
            $userData = [
                'phone' => $phoneNumber,
                'nick_name' => '用户' . rand(pow(10, (6 - 1)), pow(10, 6) - 1)
            ];
            $userId = $userService->addUser($userData);
            if (!$userId) {
                return response()->json([
                    'msg' => 'insert fail',
                ], 500);
            }
            $userData['user_id'] = $userId;
            return response()->json($userData);
        }
        return response()->json($user);
    }

    /**
     * 发送短信验证码
     *
     * @param $phoneNumber
     * @return JsonResponse
     */
    public function sendLoginValidCode($phoneNumber)
    {
        $code = rand(pow(10, (6 - 1)), pow(10, 6) - 1);
        Cache::put($phoneNumber, $code, 300);
        Log::error("发送验证码", [$code]);
//        event(new SendSMSValidCode($phoneNumber, $code));

        return response()->json(['msg' => 'ok']);
    }

}
