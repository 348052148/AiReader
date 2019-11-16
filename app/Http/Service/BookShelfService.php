<?php

namespace App\Http\Service;

use App\Book;
use App\BookShelf;
use Illuminate\Support\Facades\Log;

class BookShelfService
{

    /**
     * 获取书籍状态
     * @param $userId
     * @return array
     */
    public function getBooksStateByUserBookShelf($userId)
    {
        $books = BookShelf::where('user_id', $userId)->get();
        if ($books) {
            $books = $books->toArray();
        } else {
            $books = [];
        }
        $booksState = [];
        foreach ($books as $book) {
            $booksState[$book['book_id']] = $book['is_updated'];
        }

        return $booksState;
    }

    /**
     * 更新所有书架书籍的状态
     * @param $bookId
     * @param int $state
     * @return mixed
     */
    public function updateBookStateByAllUser($bookId, $state = 1)
    {
        Log::info("书籍更新", [$bookId]);
        return BookShelf::where('book_id', $bookId)->update([
            'is_updated' => $state
        ]);
    }

    /**
     * 更新指定用户书籍书籍状态
     * @param $userId
     * @param $bookId
     * @param int $state
     * @return mixed
     */
    public function updateBookStateByUser($userId, $bookId, $state = 0)
    {
        Log::info("更改书籍状态", [$bookId]);
        return BookShelf::where('user_id', $userId)->where('book_id', $bookId)->update([
            'is_updated' => $state
        ]);
    }

    /**
     * 获取用户书籍书籍列表
     * @param $userId
     * @return array
     */
    public function getBooksByUserBookShelf($userId)
    {
        $books = BookShelf::where('user_id', $userId)->get();
        if ($books) {
            $books = $books->toArray();
        } else {
            $books = [];
        }

        $readNumMap = array_column($books, 'read_num', 'book_id');
        $readOffsetMap = array_column($books, 'read_offset', 'book_id');
        $chapterTitleMap = array_column($books, 'chapter_title', 'book_id');
        $bookList = Book::whereIn('book_id', array_column($books, 'book_id'))->get();

        if ($bookList) {
            $bookList = $bookList->toArray();
        }

        $bookList = array_map(function ($v) use ($readNumMap, $readOffsetMap, $chapterTitleMap) {
            $v['read_num'] = array_get($readNumMap, $v['book_id'], 0);
            $v['read_offset'] = array_get($readOffsetMap, $v['book_id'], 0);
            $v['chapter_title'] = array_get($chapterTitleMap, $v['book_id'], 0);
            return $v;
        }, $bookList);

        return $bookList;
    }

    /**
     * 添加书籍进书架
     * @param $userId
     * @param $bookId
     * @param $readNum
     * @param int $readOffset
     * @return mixed
     */
    public function addBookIntoUserBookShelf($userId, $bookId, $readNum, $readOffset = 0)
    {
        return BookShelf::insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'read_num' => $readNum,
            'read_offset' => $readOffset,
            'is_updated' => 0,
            'chapter_title' => '未阅读',
        ]);
    }

    /**
     * 更新书架书籍信息
     * @param $userId
     * @param $bookId
     * @param $readNum
     * @param $readOffset
     * @return mixed
     */
    public function updateBookFromUserBookShelf($userId, $bookId, $readNum, $readOffset)
    {
        return BookShelf::where('user_id', $userId)->where('book_id', $bookId)->update([
            'read_num' => $readNum,
            'read_offset' => $readOffset,
        ]);
    }

    /**
     * 删除书籍从书架
     * @param $userId
     * @param $bookId
     * @return mixed
     */
    public function removeBookFromUserBookShelf($userId, $bookId)
    {
        return BookShelf::where('user_id', $userId)->where('book_id', $bookId)->delete();
    }

    /**
     * 设置书籍更新
     * @param $userId
     * @param $bookId
     * @return mixed
     */
    public function setBookUpdateByUserBookShelf($userId, $bookId)
    {
        $result = BookShelf::where('book_id', $bookId)->where('user_id', $userId)->update([
            'is_updated' => 1,
        ]);

        return $result;
    }

    /**
     * 清理书籍更新状态
     * @param $userId
     * @param $bookId
     * @return mixed
     */
    public function clearBookUpdateByUserBookShelf($userId, $bookId)
    {
        $result = BookShelf::where('book_id', $bookId)->where('user_id', $userId)->update([
            'is_updated' => 0,
        ]);

        return $result;
    }

}
