<?php

namespace App\BookShelf\Service;

use App\BookShelf\Commands\AddBookCommand;
use App\BookShelf\Commands\DeleteBookCommand;
use App\BookShelf\Commands\UpdateBookCommand;
use App\Infrastructure\BookShelfRepository;

class BookShelfApplicationService
{

    public function addBook(AddBookCommand $addBookCommand)
    {
        $bookshelfRepository = new BookShelfRepository();
        $bookShelf = $bookshelfRepository->getById($addBookCommand->getBookShelfId());
        $bookShelf->addBook($addBookCommand->getBook());

        return $bookshelfRepository->save($bookShelf);
    }

    public function deleteBook(DeleteBookCommand $deleteBookCommand)
    {
        $bookshelfRepository = new BookShelfRepository();
        $bookShelf = $bookshelfRepository->getById($deleteBookCommand->getBookShelfId());
        try {
            $bookShelf->deleteBook($bookShelf->getBookByBookId($deleteBookCommand->getBookId()));
        } catch (\Exception $e) {
            return false;
        }
        return $bookshelfRepository->save($bookShelf);
    }

    public function updateBookReadRecord(UpdateBookCommand $updateBookCommand)
    {
        $bookshelfRepository = new BookShelfRepository();
        $bookShelf = $bookshelfRepository->getById($updateBookCommand->getBookShelfId());
        $bookShelf->changeBookReadChapterNumber(
            $updateBookCommand->getBookId(),
            $updateBookCommand->getChapterNumber(),
            $updateBookCommand->getChapterOffset());

        return $bookshelfRepository->save($bookShelf);
    }
}