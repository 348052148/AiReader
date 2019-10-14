<?php
namespace App\Http\Service;

use App\Book;
use App\Classify;

class ClassifyService
{

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