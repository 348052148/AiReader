<?php
namespace App\BookShelf\Commands;

class UpdateBookCommand
{
    private $bookShelfId;
    private $bookId;
    private $chapterNumber;
    private $chapterOffset;

    /**
     * @return mixed
     */
    public function getBookShelfId()
    {
        return $this->bookShelfId;
    }

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
    public function getChapterNumber()
    {
        return $this->chapterNumber;
    }

    /**
     * @return mixed
     */
    public function getChapterOffset()
    {
        return $this->chapterOffset;
    }

}