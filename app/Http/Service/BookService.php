<?php
namespace App\Http\Service;
use App\Book;
use App\Chapter;
use App\Events\StoreChapterContents;
use App\Http\Parser\QuanWenParser;
use Illuminate\Support\Facades\Cache;

class BookService {

    /**
     * 获取书籍信息 By ID
     * @param $bookId
     * @return mixed
     */
    public function getBookInfoById($bookId)
    {
        return Book::where("book_id", $bookId)->first()->toArray();
    }

    /**
     * 获取书籍的章节列表
     * @param $bookId
     * @return mixed
     */
    public function getBookChapters($bookId)
    {
        $chapterList = Chapter::where("book_id", $bookId)->get()->toArray();
        return $chapterList;
    }

    /**
     * 获取章节元信息 By ID
     * @param $chapterId
     * @return mixed
     */
    public function getChapterInfoById($chapterId)
    {
        $chapter = Chapter::where("chapter_id", $chapterId)->first()->toArray();
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
        $contents = Cache::get("chapterContents:{$chapterId}", function () use ($chapterId){
            $chapter = $this->getChapterInfoById($chapterId);
            $contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
            Cache::put("chapterContents:{$chapterId}", $contents, 600);
            return $contents;
        });
        event(new StoreChapterContents($chapterId));
        return $contents;
    }

    /**
     * 缓存下一章数据
     * @param $chapterId
     * @return mixed
     */
    public function storeNextChapterContents($chapterId)
    {
        $chapter = Chapter::where('chapter_id', $chapterId)->first()->toArray();
        $nextChapter = Chapter::where('index', $chapter['index'])
            ->where("book_id", $chapter['book_id'])->first();
        if (!$nextChapter) {
            return;
        }
        $nextChapter = $nextChapter->toArray();
        //缓存
        $key = "chapterContents:{$nextChapter['chapter_id']}";
        if(!Cache::has($key)) {
            $contents = QuanWenParser::convertCatelogContents($nextChapter['content_link']);
            Cache::put($key, $contents, 600);
        }
    }
}