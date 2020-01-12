<?php

namespace App\Http\Controllers\BookShelf;

use App\Http\Controllers\Controller;
use App\Http\Service\BookService;
use App\Http\Service\BookShelfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function books(BookShelfService $bookShelfService)
    {
        $user = Auth::user();
        $books = $bookShelfService->getBooksByUserBookShelf($user['user_id']);

        return $this->apiResult(['books' => $books]);
    }

    public function addBook(BookShelfService $bookShelfService, Request $request, $bookId)
    {
        $user = Auth::user();
        $readNum = $request->input('readNum');
        $readOffset = $request->input('readOffset');
        $result = $bookShelfService->addBookIntoUserBookShelf($user['user_id'], $bookId, $readNum, $readOffset);

        return $this->apiResult([]);
    }

    public function deleteBooks(BookShelfService $bookShelfService, Request $request, $bookIds)
    {
        $user = Auth::user();
        $bookIds = explode(',', $bookIds);
        foreach ($bookIds as $bookId) {
            $result = $bookShelfService->removeBookFromUserBookShelf($user['user_id'], $bookId);
            if (!$result) {
                return response()->json(['message' => '删除失败'], 500);
            }
        }

        return $this->apiResult([]);
    }

    public function updateBook(Request $request, BookShelfService $bookShelfService, BookService $bookService, $bookId)
    {
        $user = Auth::user();
        $readNum = $request->input('readNum');
        $readOffset = $request->input('readOffset');
        $chapters = $bookService->getBookChapters($bookId);
        $readTitle = collect($chapters)->take($readNum)['title'];
        $result = $bookShelfService->updateBookFromUserBookShelf($user['user_id'], $bookId, $readNum, $readOffset, $readTitle);

        return $this->apiResult([]);
    }
}
