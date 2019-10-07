<?php
namespace App\Http\Model;
class Catalog {
    //目录名称
    public $catalogName;
    //目录序
    public $sortField;

    public $url;

    public function __construct($cateName, $sortField, $url)
    {
        $this->catalogName = $cateName;
        $this->sortField = $sortField;

        $this->url = $url;
    }
}
