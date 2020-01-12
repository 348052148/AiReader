<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendSMSValidCode;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function username()
    {
        return 'phone';
    }

    //登陆
    protected function authenticated(Request $request, $user)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
        return $this->apiResult([
            'user' => Auth::user(),
            'token' => $token
        ]);
    }

    //退出登陆
    protected function loggedOut(Request $request)
    {
        return $this->apiResult([]);
    }

    //登陆byPhone
    public function loginByPhone(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'code' => 'required|string',
        ]);
        //验证
        if (!Cache::has($request->input($this->username()))) {
            throw new \Exception('验证码错误1');
        } elseif (Cache::get($request->input($this->username())) != $request->input('code')) {
            throw new \Exception('验证码错误');
        }

        $user = User::where('phone', $request->input('phone'))->first();
        if (!$user) {
            $user = User::create([
                'phone' => $request->input($this->username()),
                'nick_name' => '用户' . rand(pow(10, (6 - 1)), pow(10, 6) - 1),
                'api_token' => Str::random(60),
            ]);
        }
        if ($this->guard()->loginUsingId($user->user_id, false)) {
            $request->session()->regenerate();
            return $this->authenticated($request, $this->guard()->user());
        } else {
            return $this->sendFailedLoginResponse($request);
        }
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
        event(new SendSMSValidCode($phoneNumber, $code));

        return $this->apiResult([]);
    }
}
