<?php
//聚合根存储接口
namespace App\BookShelf\Repositories;


use App\BookShelf\Models\BookShelf;

interface BookShelfRepository
{
    public function getById($id):BookShelf;

    public function save(BookShelf $bookShelf);
}
