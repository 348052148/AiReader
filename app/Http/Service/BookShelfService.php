<?php

namespace App\Http\Service;

use App\BookShelf;

class BookShelfService
{

    /**
     * 获取用户书籍书籍列表
     * @param $userId
     * @return array
     */
    public function getBooksByUserBookShelf($userId)
    {
        $books = BookShelf::where('book_id', $userId)->get();
        if ($books) {
            return $books->toArray();
        }

        return [];
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
