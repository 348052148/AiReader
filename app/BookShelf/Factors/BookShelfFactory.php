<?php
//创建聚合根
namespace App\BookShelf\Factors;

use App\BookShelf\Models\Book;
use App\BookShelf\Models\BookShelf;

class BookShelfFactory
{
    public static function create(array $books): BookShelf
    {
        $bookShelf = new BookShelf();
        foreach ($books as $bookData) {
            $book = new Book();
            $book->setBookId($bookData['book_id']);
            $book->setReadChapterNumber($bookData['read_num']);
            $book->setReadChapterOffset($bookData['read_offset']);
            $book->setBookIsUpdated($bookData['is_updated']);
            $book->setReadChapterTitle($bookData['chapter_title']);
            $bookShelf->addBook($bookData);
        }

        return $bookShelf;
    }
}