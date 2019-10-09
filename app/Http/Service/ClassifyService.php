<?php
namespace App\Http\Service;

use App\Book;
use App\Classify;

class ClassifyService
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClassifyList()
    {
        return Classify::all()->toArray();
    }

    public function getClassifyBookList($classifyId)
    {
        $bookList = Book::where("classify_id", $classifyId)->get()->toArray();

        return $bookList;
    }
}