<?php

namespace App\Http\Controllers;

use App\Book;
use App\Chapter;
use App\Http\Parser\QuanWenParser;
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

        $book = Book::where("book_id", $bookId)->first()->toArray();

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
        $chapterList = Chapter::where("book_id", $bookId)->get()->toArray();

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
        $chapter = Chapter::where("chapter_id", $chapterId)->first()->toArray();
        $contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'contents' => $contents,
        ]);
    }
}
