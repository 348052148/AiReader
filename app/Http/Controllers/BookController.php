<?php

namespace App\Http\Controllers;

use App\Events\BookAlreadyReaded;
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
     * @SWG\Definition(
     *     definition="Book",
     *     type="object",
     *     required={"username"},
     *     @SWG\Property(
     *         property="book_id",
     *         type="string",
     *         description="书籍id"
     *      ),
     *    @SWG\Property(
     *         property="title",
     *         type="string",
     *         description="书籍名称"
     *       ),
     *    @SWG\Property(
     *          property="cover",
     *          type="string",
     *          description="封面图"
     *       ),
     *    @SWG\Property(
     *           property="author",
     *           type="string",
     *           description="作者名称"
     *       ),
     *    @SWG\Property(
     *           property="classify_id",
     *           type="string",
     *           description="分类id"
     *       ),
     *    @SWG\Property(
     *            property="chapter_count",
     *            type="string",
     *            description="章节数目"
     *      ),
     * )
     */


    /**
     * @SWG\Get(
     *      path="/book/{book_id}",
     *     summary="获取书籍信息",
     *     description="根据书籍id获取书籍信息",
     *     @SWG\Response(
     *          response=200,
     *          description="书籍信息",
     *           @SWG\Schema(ref="#/definitions/Book")
     *      )
     * )
     */
    /**
     * 获取小说信息
     * @param Request $request
     * @param BookService $bookService
     * @param $bookId
     * @return JsonResponse
     * @throws Exception
     */
    public function bookDetail(Request $request, BookService $bookService, $bookId)
    {
        $book = $bookService->getBookInfoById($bookId);

        //如果没有
        if (empty($book['chapter_count'])) {
            $book['chapter_count'] = $bookService->getBookChapterCount($bookId);
        }

        event(new StoreBookContents($bookId));

        return response()->json($book);
    }

    /**
     * @SWG\Get(
     *      path="/book/{book_id}/recommend",
     *     summary="获取推荐书籍",
     *     description="根据书籍id获取推荐书籍",
     *     @SWG\Response(
     *          response=200,
     *          description="书籍信息",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Book")
     *         )
     *      )
     * )
     */

    /**
     * 根据书籍推荐
     * @param BookService $bookService
     * @param $bookId
     * @return JsonResponse
     */
    public function recommendAsBooks(BookService $bookService, $bookId)
    {
        $recommendBooks = $bookService->getRecommendBooks();

        return response()->json($recommendBooks);
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
        $page = $request->input('page', null);
        $chapterList = $bookService->getBookChapters($bookId);
        if (!is_null($page)) {
            $list = collect($chapterList)->forPage($page, 100);
            return response()->json([
                'page' => $page,
                'count' => $list->count(),
                'list' => $list->toArray()
            ]);
        } else {
            return response()->json($chapterList);
        }
    }

    /**
     * 获取章节内容
     * @param BookService $bookService
     * @param TextHandleService $textHandleService
     * @param $chapterId
     * @return JsonResponse
     */
    public function chapterContents(BookService $bookService, TextHandleService $textHandleService, $chapterId)
    {
        $time1 = microtime(true);
        $contents = $bookService->getChapterContents($chapterId);
        $time2 = microtime(true);
        $contents = $textHandleService->ParserText($contents);
        $time3 = microtime(true);
        event(new StoreChapterContents($chapterId));
        $time4 = microtime(true);
        Log::info("获取内容执行时间统计：", [$time2 - $time1, $time3 - $time2, $time4 - $time3]);

        return response()->json($contents);
    }

    /**
     * 获取书籍指定索引章节内容
     * @param BookService $bookService
     * @param TextHandleService $textHandleService
     * @param $bookId
     * @param $index
     * @return JsonResponse
     * @throws Exception
     */
    public function chapterContentsByIndex(Request $request, BookService $bookService, TextHandleService $textHandleService, $bookId, $index)
    {
        $chapter = $bookService->getBookChapterByIndex($bookId, $index);
        $contents = $textHandleService->ParserText(
            $bookService->getChapterContents($chapter['chapter_id']));
        event(new StoreChapterContents($chapter['chapter_id']));

        //如果是否正常阅读过，阅读过则改变书架书籍更新状态
        $isRead = $request->input("is_read", false);
        $userId = $request->input("user_id", "");
        if ($isRead) {
            event(new BookAlreadyReaded($userId, $bookId));
        }

        return response()->json(['title' => $chapter['title'], 'contents' => $contents]);
    }

    /**
     * @param ImageService $imageService
     * @param $bookId
     * @return StreamedResponse
     */
    public function image(ImageService $imageService, $bookId)
    {
        return response()->stream(function () use ($imageService, $bookId) {
            echo $imageService->getBookCoverImage($bookId);
        }, 200, ['Content-Type' => 'image/jpeg', 'Cache-Control' => 'max-age=315360000']);
    }
}
