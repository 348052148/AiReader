<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|min:6',
        ];
    }

    /**
     * 
     */
    public function restPassword(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $password = $request->input('password');
        $user = Auth::user();
        Log::error('', [$user]);
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['status' => true]);
    }

}
