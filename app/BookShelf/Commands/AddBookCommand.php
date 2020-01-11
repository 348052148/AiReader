<?php
namespace App\BookShelf\Commands;
//命令 ApplicationService 使用 Representation
class AddBookCommand
{
    private $bookShelfId;

    private $book;

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
    public function getBook()
    {
        return $this->book;
    }

}