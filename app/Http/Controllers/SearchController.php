<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Parser\QuanWenParser;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * 搜索书籍
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBooks(Request $request)
    {
        $keyword = $request->input('keyword', null);
        $page = $request->input('page',1);
        if (is_null($keyword)) {
            $bookList = Book::All()->offset(($page-1) * 20)->limit(20)->toArray();
        } else {
            $bookList = Book::where("title","like","%{$keyword}%")->offset(($page-1) * 20)->limit(20)->get()->toArray();
        }

        //$bookList = QuanWenParser::convertSearchBooks($request->input('keyword'),$request->input('page',''));

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'list' => $bookList
        ]);
    }

}
