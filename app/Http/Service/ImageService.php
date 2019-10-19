<?php
namespace App\Http\Service;

class ImageService
{

    public function getImage($url)
    {
        return file_get_contents($url);
    }

    public function image($url)
    {
        return urlencode('http://127.0.0.1:8000/api/image?url='.$url);
    }
}