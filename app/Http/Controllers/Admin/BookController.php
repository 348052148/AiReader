<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function bookList(Request $request, $page)
    {
        $books = Book::paginate(20, ['*'], 'page', $page);

        return response()->json($books);
    }

    /**
     * 修改书籍
     * @param Request $request
     * @param $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBook(Request $request, $bookId)
    {
        $res = Book::where('book_id', $bookId)->update([
           'title' => $request->input('title'),
           'author' => $request->input('author'),
           'detail' => $request->input('detail'),
           'status' => $request->input('status')
        ]);
        if (!$res) {
           return response()->json('更新失败', 500);
        }

        return response()->json('ok');
    }

    /**
     * 删除书籍
     * @param Request $request
     * @param $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBook(Request $request, $bookId)
    {
        $res = Book::where('book_id', $bookId)->delete();
        if (!$res) {
            return response()->json('更新失败', 500);
        }

        return response()->json('ok');
    }

    /**
     * 获取章节
     * @param Request $request
     * @param $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookChapterList(Request $request, $bookId){
        $chapterList = Chapter::where('book_id', $bookId)->get();
        if (!$chapterList) {
            return response()->json('获取失败', 500);
        }

        return response()->json($chapterList);
    }
}
