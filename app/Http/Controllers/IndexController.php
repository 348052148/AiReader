<?php

namespace App\Http\Controllers;

use App\Http\Service\BookService;
use App\Jobs\StoreChapterContentsJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function index(BookService $bookService)
    {
        echo encrypt("12321qweqweqwewqeq3");
//        $chapters = $bookService->getBookChapters('0202b04d8aebd2afc56c586fcd228b87');
//        return response()->json($chapters);
    }

    /**
     * 展示橱窗
     * @param Request $request
     * @return JsonResponse
     */
    public function bannarBooks(Request $request)
    {
        $banarList = [
            [
                'title' => '推荐书籍',
                'img' => 'https://sta-op.douyucdn.cn/nggsys/2019/10/16/e5e1d8fdac31df37f638d678903410be.jpg',
                'link' => ''
            ],
            [
                'title' => '书籍',
                'img' => 'https://images.unsplash.com/photo-1551214012-84f95e060dee?w=1200',
                'link' => ''
            ]
        ];
        return response()->json($banarList);
    }

    /**
     * 热门书籍
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function hotBooks(BookService $bookService)
    {
        $hotBooks = $bookService->getHotBooks();

        return response()->json($hotBooks);
    }

    /**
     * 推荐书籍
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function recommendBooks(BookService $bookService)
    {
        $recommendBooks = $bookService->getRecommendBooks();

        return response()->json($recommendBooks);
    }
}
