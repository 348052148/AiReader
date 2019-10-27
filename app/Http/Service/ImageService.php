<?php

namespace App\Http\Service;

class ImageService
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     *获取书籍封面图片
     * @param $bookId
     * @return false|string
     * @throws \Exception
     */
    public function getBookCoverImage($bookId)
    {
        $fileName = storage_path("img") . "{$bookId}.jpeg";
        if (file_exists($fileName)) {
            $contents = file_get_contents($fileName);
        } else {
            $book = $this->bookService->getBookInfoById($bookId);
            $contents = file_get_contents($book['cover']);
            file_put_contents($fileName, $contents);
        }

        return $contents;
    }

    public function image($url)
    {
        return urlencode('http://127.0.0.1:8000/api/image?url=' . $url);
    }
}