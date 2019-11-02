<?php

namespace App\Http\Service;

use App\Book;
use App\Chapter;
use App\Http\Parser\QuanWenParser;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Srv\ChapterRequest;
use Srv\ChapterResponse;

class BookService extends BaseService
{

    /**
     * 获取热门书籍
     * @return array
     */
    public function getHotBooks()
    {
        $books = Book::limit(6)->get();
        if (!$books) {
            return [];
        }

        return $books->toArray();
    }

    /**
     * 获取推荐书籍
     * @return array
     */
    public function getRecommendBooks()
    {
        $books = Book::offset(10)->limit(6)->get();
        if (!$books) {
            return [];
        }

        return $books->toArray();
    }

    /**
     * 获取书籍信息 By ID
     * @param $bookId
     * @return mixed
     * @throws Exception
     */
    public function getBookInfoById($bookId)
    {
        $book = Book::where("book_id", $bookId)->first();
        if (!$book) {
            throw new Exception('不存在此书籍');
        }
        return $book->toArray();
    }

    /**
     * 获取书籍章节数
     * @param $bookId
     * @return mixed
     */
    public function getBookChapterCount($bookId)
    {
        return Chapter::where("book_id", $bookId)->count();
    }

    /**
     * 获取书籍的章节列表
     * @param $bookId
     * @return mixed
     */
    public function getBookChapters($bookId)
    {
        $chapters = Cache::get("chapters:{$bookId}", function () use ($bookId) {
            $book = $this->getBookInfoById($bookId);
            list($result, $status) = $this->_simpleRequest(
                '/srv.ParserService/ParserChapters',
                new ChapterRequest(['link' => $book['chapter_link']]),
                [ChapterResponse::class, 'decode']
            )->wait();
            if ($status->code) {
                throw new Exception($status->details);
            }
            $chapters = [];
            foreach ($result->getChapters() as $chapter) {
                $chapters[] = [
                    'book_id' => $bookId,
                    'title' => $chapter->getTitle(),
                    'index' => $chapter->getIndex(),
                    'content_link' => $chapter->getContentsLink(),
                ];
            }
            //保存书籍章节信息
            Cache::put("chapters:{$bookId}", $chapters, 86400);
            return $chapters;
        });

        return $chapters;
    }

    /**
     * 获取章节元信息 By ID
     * @param $chapterId
     * @return mixed
     * @throws Exception
     */
    public function getChapterInfoById($chapterId)
    {
        $chapter = Chapter::where("chapter_id", $chapterId)->first()->toArray();
        if (!$chapter) {
            throw new Exception('未找到此章节');
        }
        return $chapter;
    }

    /**
     * 获取章节内容
     * @param $chapterId
     * @return mixed
     */
    public function getChapterContents($chapterId)
    {
        //缓存章节内容
        $contents = Cache::get("chapterContents:{$chapterId}", function () use ($chapterId) {
            Log::info("未命中章节{$chapterId}缓存");
            $chapter = $this->getChapterInfoById($chapterId);
            $contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
            Cache::put("chapterContents:{$chapterId}", $contents, 86400);
            return $contents;
        });

        return $contents;
    }

    /**
     * 获取书籍章节信息 by 章节索引
     * @param $bookId
     * @param $index
     * @return mixed
     * @throws Exception
     */
    public function getBookChapterByIndex($bookId, $index)
    {
        $chapters = $this->getBookChapters($bookId);
        $chapter = collect($chapters)->where('index', $index)->first();
//        $chapter = Chapter::where('book_id', $bookId)->where('index', $index)->first();
        if (!$chapter) {
            throw new Exception('未找到此章节');
        }

        return $chapter->toArray();
    }

    /**
     * 缓存下一章数据
     * @param $chapterId
     * @return mixed
     */
    public function storeNextChapterContents($chapterId)
    {
        $chapter = Chapter::where('chapter_id', $chapterId)->first()->toArray();
        $nextChapter = Chapter::where('index', $chapter['index'] + 1)
            ->where("book_id", $chapter['book_id'])->first();
        if (!$nextChapter) {
            return;
        }
        $nextChapter = $nextChapter->toArray();
        //缓存
        $key = "chapterContents:{$nextChapter['chapter_id']}";
        if (!Cache::has($key)) {
            $contents = QuanWenParser::convertCatelogContents($nextChapter['content_link']);
            Cache::put($key, $contents, 86400);
        }
    }

    /**
     * 缓存book内容
     * @param $bookId
     */
    public function storeBookContents($bookId)
    {
        $chapter = Chapter::where('book_id', $bookId)->where('index', 0)->first();
        if (!$chapter) {
            return;
        }
        $chapter = $chapter->toArray();
        //缓存book
        $key = "chapterContents:{$chapter['chapter_id']}";
        if (!Cache::has($key)) {
            $contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
            Cache::put($key, $contents, 86400);
        }
    }

    /**
     * 更新书籍章节数
     * @param $bookId
     * @param $chapterCount
     * @return mixed
     */
    public function updateBookChapterCount($bookId, $chapterCount)
    {
        return Book::where('book_id', $bookId)->update([
            'chapter_count' => $chapterCount
        ]);
    }
}