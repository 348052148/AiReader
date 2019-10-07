<?php

namespace App\Http\Controllers;

use App\Http\Parser\QuanWenParser;
use Illuminate\Http\Request;

class ClassflyController extends Controller
{
    /**
     * 获取分类列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classflyList(Request $request)
    {
        $classflys = QuanWenParser::convertClassflys();

        return response()->json([
                'code' => 0,
                'msg' => 'ok',
                'list' => $classflys
            ]
        );
    }

    /**
     * 获取分类下书籍列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classflyBooks(Request $request)
    {
        $bookList = QuanWenParser::convertSearchClassfly(
            $request->input('url'), $request->input('page', ''));
        return response()->json([
                'code' => 0,
                'msg' => 'ok',
                'list' => $bookList
            ]
        );
    }
}
