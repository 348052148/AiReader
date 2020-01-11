<?php

namespace App\BookShelf\Models;

class Book
{
    private $bookId;
    private $bookShelfId;
    private $readChapterNumber;
    private $readChapterOffset;
    private $bookIsUpdated;
    private $readChapterTitle;

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @return mixed
     */
    public function getReadChapterNumber()
    {
        return $this->readChapterNumber;
    }

    /**
     * @return mixed
     */
    public function getReadChapterOffset()
    {
        return $this->readChapterOffset;
    }

    /**
     * @return mixed
     */
    public function getBookIsUpdated()
    {
        return $this->bookIsUpdated;
    }

    /**
     * @return mixed
     */
    public function getReadChapterTitle()
    {
        return $this->readChapterTitle;
    }

    /**
     * @param mixed $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * @param mixed $readChapterNumber
     */
    public function setReadChapterNumber(int $readChapterNumber)
    {
        $this->readChapterNumber = $readChapterNumber;
    }

    /**
     * @param mixed $readChapterOffset
     */
    public function setReadChapterOffset(int $readChapterOffset)
    {
        $this->readChapterOffset = $readChapterOffset;
    }

    /**
     * @param mixed $bookIsUpdated
     */
    public function setBookIsUpdated(bool $bookIsUpdated)
    {
        $this->bookIsUpdated = $bookIsUpdated;
    }

    /**
     * @param mixed $readChapterTitle
     */
    public function setReadChapterTitle(string $readChapterTitle)
    {
        $this->readChapterTitle = $readChapterTitle;
    }

    /**
     * 比较
     * @param Book $book
     * @return bool
     */
    public function equals(Book $book)
    {
        return $this->bookId == $book->bookId;
    }
}