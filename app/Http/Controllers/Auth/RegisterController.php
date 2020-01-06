<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    protected function registered(Request $request, $user)
    {
        return response()->json(['user'=> $user]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     * @throws \Exception
     */
    protected function validator(array $data)
    {
        if (!Cache::has($data['phone'])) {
            throw new \Exception('验证码错误');
        } elseif (Cache::get($data['phone']) != $data['code']) {
            throw new \Exception('验证码错误');
        }

        if ($data['repeatPassword'] != $data['password']) {
            throw new \Exception('密码重复输入错误');
        }

        return Validator::make($data, [
            'phone' => 'required|string|unique:w_users',
            'password' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'phone' => $data['phone'],
            'nick_name' => '用户' . rand(pow(10, (6 - 1)), pow(10, 6) - 1),
            'password' => bcrypt($data['password']),
            'api_token' => Str::random(60),
        ]);
    }

    public function redirectPath()
    {
        //
    }
}
