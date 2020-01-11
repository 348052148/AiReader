<?php
namespace App\BookShelf\Commands;
//命令 ApplicationService 使用 Representation
class DeleteBookCommand
{
    private $bookShelfId;

    private $bookId;

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

}