<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function bookList(Request $request, $page)
    {
        $books = Book::paginate(20, ['*'], 'page', $page);

        return response()->json($books);
    }
}
