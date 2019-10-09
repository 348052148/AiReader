<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Service\SearchService;
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
        $bookList = SearchService::getInstance()->search($request->input('keyword'),$request->input('page',''));

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'list' => $bookList
        ]);
    }

}
