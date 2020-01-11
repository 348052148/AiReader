<?php

namespace App\Infrastructure;

use App\BookShelf\Factors\BookShelfFactory;
use App\BookShelf\Models\BookShelf;
use App\BookShelf\Repositories\BookShelfRepository as IRepository;

class BookShelfRepository implements IRepository
{

    public function getById($id): BookShelf
    {
        $books = \App\BookShelf::where('user_id', $id)->get()->toArray();
        return BookShelfFactory::create($books);
    }

    public function save(BookShelf $bookShelf)
    {
        $bookShelfId = $bookShelf->getBookShelfId();
        foreach ($bookShelf->getBooks() as $book) {
            \App\BookShelf::updateOrCreate(['id' => $bookShelfId, 'book_id' => $book->getBookId()], $book);
        }

        return true;
    }
}
