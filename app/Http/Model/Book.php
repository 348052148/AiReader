<?php
namespace App\Http\Model;
class Book {
    //类别
    public $classfiy;
    //作者
    public $author;
    //介绍
    public $detail;
    //状态 连载，完结。
    public $status;
    //封面
    public $coverImg;
    //书名
    public $title;

    public $url;

    public $source;

    /**
     * 添加目录到书籍
     * @param $catelog
     */

    public function __construct($title, $classfiy, $author,$status, $coverImg, $detail, $url)
    {
        $this->title = $title;
        $this->classfiy = $classfiy;
        $this->author = $author;
        $this->status = $status;
        $this->coverImg = $coverImg;
        $this->detail = $detail;

        $this->url = $url;

        $this->source = '全文网';
    }


    public function toArray()
    {
        return [
            'title' => $this->title,
            'classfiy' => $this->classfiy,
            'author' => $this->author,
            'status' => $this->status,
            'coverImg' => $this->coverImg,
            'detail' => $this->detail,
            'url' => $this->url,
        ];
    }

}