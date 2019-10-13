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
        return response()->json($booklist);
    }

    /**
     * 展示橱窗
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bannarBooks(Request $request)
    {
        return response()->json([
            'url' => '',
            'img' => '',
            'title' => '逆天改命'
        ]);
    }

    /**
     * 热门书籍
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hotBooks(Request $request)
    {
        return response()->json([
            'url' => '',
            'img' => '',
            'title' => '逆天改命'
        ]);
    }

    /**
     * 推荐书籍
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommendBooks(Request $request)
    {
        return response()->json([
            'url' => '',
            'img' => '',
            'title' => '逆天改命'
        ]);
    }
}
