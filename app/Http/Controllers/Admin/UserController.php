<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userList(Request $request, $page)
    {
        $userList = User::paginate(20, ['*'], 'page', $page);

        return response()->json($userList);
    }
}
