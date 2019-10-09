<?php

namespace App\Http\Controllers;

use App\Http\Service\BookService;
use App\Http\Service\TextHandleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    /**
     * 获取小说信息
     * @param Request $request
     * @param Response $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookDetail(Request $request, Response $response, $bookId)
    {
        //$book = QuanWenParser::convertBook($request->input("url"));

        $book = BookService::getInstance()->getBookInfoById($bookId);

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'info' => $book,
        ]);
    }

    /**
     * 获取小说章节目录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookChapters(Request $request, $bookId)
    {
        $chapterList = BookService::getInstance()->getBookChapters($bookId);

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'list' => $chapterList,
        ]);
    }

    /**
     * 获取章节内容
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chapterContents(Request $request, $chapterId)
    {
        $contents = BookService::getInstance()->getChapterContents($chapterId);
        $contents = TextHandleService::getInstance()->ParserText($contents);

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'contents' => $contents,
        ]);
    }
}
