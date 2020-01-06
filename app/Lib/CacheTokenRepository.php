<?php

namespace App\Lib;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Cache;

class CacheTokenRepository implements TokenRepositoryInterface
{
    public function create(CanResetPasswordContract $user)
    {
        return Cache::put($user['phone'], $this->createToken(), 300);
    }

    protected function createToken()
    {
        return rand(pow(10, (6 - 1)), pow(10, 6) - 1);
    }

    public function delete(CanResetPasswordContract $user)
    {
        return Cache::forget($user['phone']);
    }

    public function deleteExpired()
    {

    }

    public function exists(CanResetPasswordContract $user, $token)
    {
        return Cache::has($user['phone']) && Cache::get($user['phone']) == $token;
    }
}
