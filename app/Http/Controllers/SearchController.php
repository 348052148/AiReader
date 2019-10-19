<?php

namespace App\Http\Controllers;

use App\Http\Service\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * 搜索书籍
     * @param Request $request
     * @param SearchService $searchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBooks(Request $request, SearchService $searchService)
    {
        $bookList = $searchService->search($request->input('keyword'), $request->input('page', ''));

        return response()->json([
            'page' => $request->input('page', ''),
            'count' => 20,
            'list' => $bookList
        ]);
    }

    /**
     * 复合搜索
     * @param Request $request
     * @param SearchService $searchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchMixedBooks(Request $request, SearchService $searchService)
    {
        $bookList = $searchService->searchByAttr($request->input('attr', ''),
            $request->input('page', ''));

        return response()->json([
            'page' => $request->input('page', ''),
            'count' => 20,
            'list' => $bookList
        ]);
    }

}
