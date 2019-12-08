<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;

class BookController extends Controller
{

    public function books()
    {

        return response()->json([
            [
                'title' => '程序员教程第五版',
                'cover' => 'http://img.quanshuwang.com/image/170/170787/170787s.jpg',
            ],
            [
                'title' => '操作系统精髓与设计原理',
                'cover' => 'http://img.quanshuwang.com/image/170/170787/170787s.jpg',
            ],
        ]);
    }
}