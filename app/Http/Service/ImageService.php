<?php

namespace App\Http\Service;

class ImageService
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function getImage($bookId)
    {
        $book = $this->bookService->getBookInfoById($bookId);
        return file_get_contents($book['cover']);
    }

    public function image($url)
    {
        return urlencode('http://127.0.0.1:8000/api/image?url=' . $url);
    }
}