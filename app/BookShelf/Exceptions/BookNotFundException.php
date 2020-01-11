<?php
namespace App\BookShelf\Exception;

use Throwable;

class BookNotFundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("书籍未找到", 404, null);
    }
}