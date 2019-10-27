<?php

namespace App\Http\Controllers;

use App\Events\StoreBookContents;
use App\Events\StoreChapterContents;
use App\Http\Service\BookService;
use App\Http\Service\ImageService;
use App\Http\Service\TextHandleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{

    /**
     * 获取小说信息
     * @param Request $request
     * @param BookService $bookService
     * @param $bookId
     * @return JsonResponse
     * @throws Exception
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function chapterContents(Request $request, BookService $bookService, TextHandleService $textHandleService, $chapterId)
    {
        $time1 = microtime(true);
        $contents = $bookService->getChapterContents($chapterId);
        $time2 = microtime(true);
        $contents = $textHandleService->ParserText($contents);
        $time3 = microtime(true);
        event(new StoreChapterContents($chapterId));
        $time4 = microtime(true);
        Log::info("获取内容执行时间统计：",[$time2-$time1, $time3-$time2, $time4 - $time3]);

        return response()->json($contents);
    }

    /**
     * @param ImageService $imageService
     * @param $bookId
     * @return StreamedResponse
     */
    public function image(ImageService $imageService, $bookId)
    {
        return response()->stream(function () use ($imageService, $bookId) {
            echo $imageService->getImage($bookId);
        }, 200, ['Content-Type' => 'image/jpeg']);
    }
}
