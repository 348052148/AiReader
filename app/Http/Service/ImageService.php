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


    public function downloadImage($url, $fileName)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $fileData = curl_exec($ch);
        curl_close($ch);

        $this->saveAsImage($fileData, $fileName);
    }

    private function saveAsImage($fileData, $fileName)
    {
        $resource = fopen($fileName, 'a');
        fwrite($resource, $fileData);
        fclose($resource);
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
        if (!file_exists($fileName)) {
            try {
                $book = $this->bookService->getBookInfoById($bookId);
                $this->downloadImage($book['cover'], $fileName);
            } catch (Exception $exception) {
                //默认书籍
                $fileName = 'http://www.quanshuwang.com/modules/article/images/nocover.jpg';
            }
        }
        //默认图片
        $contents = file_get_contents($fileName);

        return $contents;
    }

    public function image($url)
    {
        return urlencode('http://127.0.0.1:8000/api/image?url=' . $url);
    }
}