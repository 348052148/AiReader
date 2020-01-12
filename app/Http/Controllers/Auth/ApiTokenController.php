<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{

    /**
     * 更新认证用户的 API 令牌。
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return $this->apiResult([
            'token' => $token
        ]);
    }

    public function user()
    {
        return $this->apiResult([
            'user' => Auth::user()
        ]);
    }
}