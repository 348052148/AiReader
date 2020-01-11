<?php

namespace App\BookShelf\Models;

use App\BookShelf\Exception\BookNotFundException;

class BookShelf extends DomainEventAwareAggregate
{
    private $bookShelfId;
    private $books = [];

    /**
     * @return mixed
     */
    public function getBookShelfId()
    {
        return $this->bookShelfId;
    }


    /**
     * @return array
     */
    public function getBooks(): array
    {
        return $this->books;
    }

    /**
     * 添加书籍到书架
     * @param Book $book
     */
    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    /**
     * 删除书籍从书架
     * @param Book $book
     */
    public function deleteBook(Book $book)
    {
        $this->books = array_filter($this->books, function (Book $b) use ($book) {
            return !$book->equals($b);
        });
    }

    /**
     * @param $bookId
     * @return mixed
     * @throws \Exception
     */
    public function getBookByBookId($bookId): Book
    {
        foreach ($this->books as $book) {
            if ($book->getBookId() == $bookId) {
                return $book;
            }
        }
        throw new BookNotFundException();
    }

    /**
     * 修改书籍
     * @param Book $book
     */
    public function changeBook(Book $book)
    {
        array_walk($this->books, function (Book $b) use ($book) {
            if ($b->equals($book)) {
                $b = $book;
            }
        });
    }

    /**
     * @param $bookId
     * @param int $chapterNumber
     * @param int $chapterOffset
     * @return bool
     */
    public function changeBookReadChapterNumber($bookId, int $chapterNumber, int $chapterOffset)
    {
        try {
            $book = $this->getBookByBookId($bookId);
        } catch (\Exception $e) {
            return false;
        }
        $book->setReadChapterNumber($chapterNumber);
        $book->setReadChapterOffset($chapterOffset);

        $this->changeBook($book);

        return true;
    }


}