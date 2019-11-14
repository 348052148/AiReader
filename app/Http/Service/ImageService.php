<?php

namespace App\Http\Service;

use Exception;

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
     * @throws Exception
     */
    public function getBookCoverImage($bookId)
    {
        if (empty($bookId)) {
            $bookId = "000000000000";
        }
        $fileName = storage_path("img") . DIRECTORY_SEPARATOR . "{$bookId}.jpeg";
        if (file_exists($fileName)) {
            $contents = file_get_contents($fileName);
        } else {
            try {
                $book = $this->bookService->getBookInfoById($bookId);
                $contents = file_get_contents($book['cover']);
                if (!$contents) {
                    throw new Exception('Not Fund');
                }
            } catch (Exception $exception) {
                //默认书籍
                $contents = file_get_contents('http://www.quanshuwang.com/modules/article/images/nocover.jpg');
            } finally {
                file_put_contents($fileName, $contents);
            }
        }

        return $contents;
    }

    public function image($url)
    {
        return urlencode('http://127.0.0.1:8000/api/image?url=' . $url);
    }
}