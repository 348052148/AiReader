<?php
namespace App\Http\Service;
use App\Book;
use App\Chapter;
use App\Http\Parser\QuanWenParser;

class BookService {

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

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
        $chapter = $this->getChapterInfoById($chapterId);
        $contents = QuanWenParser::convertCatelogContents($chapter['content_link']);

        return $contents;
    }
}