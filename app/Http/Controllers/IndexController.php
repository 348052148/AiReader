<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function index(Request $request)
    {
        $booklist = Book::all();
        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'list' => $booklist,
        ]);
    }
}
