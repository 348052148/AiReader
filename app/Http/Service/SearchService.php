<?php
namespace App\Http\Service;
use App\Book;

class SearchService {

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 搜索书籍服务
     * @param $keyword
     * @param int $page
     * @return mixed
     */
    public function search($keyword, $page = 1)
    {
        if (is_null($keyword)) {
            $bookList = Book::all()->offset(($page-1) * 20)->limit(20)->toArray();
        } else {
            $bookList = Book::where("title","like","%{$keyword}%")->offset(($page-1) * 20)->limit(20)->get()->toArray();
        }

        return $bookList;
    }
}