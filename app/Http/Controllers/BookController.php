<?php

namespace App\Http\Controllers;

use App\Events\StoreBookContents;
use App\Events\StoreChapterContents;
use App\Http\Service\BookService;
use App\Http\Service\TextHandleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    /**
     * 获取小说信息
     * @param Request $request
     * @param BookService $bookService
     * @param $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookDetail(Request $request,BookService $bookService, $bookId)
    {
        $book = $bookService->getBookInfoById($bookId);
        event(new StoreBookContents($bookId));

        return response()->json($book);
    }

    /**
     * 获取小说章节目录
     * @param Request $request
     * @param BookService $bookService
     * @param $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookChapters(Request $request, BookService $bookService, $bookId)
    {
        $chapterList = $bookService->getBookChapters($bookId);

        return response()->json($chapterList);
    }

    /**
     * 获取章节内容
     * @param Request $request
     * @param BookService $bookService
     * @param TextHandleService $textHandleService
     * @param $chapterId
     * @return \Illuminate\Http\JsonResponse
     */
    public function chapterContents(Request $request, BookService $bookService, TextHandleService $textHandleService, $chapterId)
    {
        $contents = $bookService->getChapterContents($chapterId);
        $contents = $textHandleService->ParserText($contents);
        event(new StoreChapterContents($chapterId));

        return response()->json($contents);
    }
}
