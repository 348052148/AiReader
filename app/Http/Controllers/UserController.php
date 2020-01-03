<?php

namespace App\Http\Controllers;

use App\Http\Service\BookShelfService;
use App\Http\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户信息
     * @param UserService $userService
     * @param $openid
     * @return JsonResponse
     */
    public function userInfo(UserService $userService, $openid)
    {
        $user = $userService->fundUserByOpenId($openid);

        return response()->json($user);
    }

    /**
     * 获取用户书架书籍
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @return JsonResponse
     */
    public function userBookShelf(BookShelfService $bookShelfService, $userId)
    {
        $books = $bookShelfService->getBooksByUserBookShelf($userId);

        return response()->json($books);
    }

    /**
     * 删除书籍从书架
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @param $bookId
     * @return JsonResponse
     */
    public function removeBookForBookShelf(BookShelfService $bookShelfService, $userId, $bookId)
    {
        $result = $bookShelfService->removeBookFromUserBookShelf($userId, $bookId);

        return response()->json($result);
    }

    /**
     * 批量删除
     * @param Request $request
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @return JsonResponse
     */
    public function removeBooksForBookShelf(Request $request, BookShelfService $bookShelfService, $userId)
    {
        $bookIds = $request->input('bookIds');
        foreach ($bookIds as $bookId) {
            $result = $bookShelfService->removeBookFromUserBookShelf($userId, $bookId);
            if ($result) {
                return response()->json('删除失败', 500);
            }
        }

        return response()->json();
    }

    /**
     * @param Request $request
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @param $bookId
     * @return JsonResponse
     */
    public function updateBookForBookShelf(Request $request, BookShelfService $bookShelfService, $userId, $bookId)
    {
        $readNum = $request->input('readNum');
        $readOffset = $request->input('readOffset');
        $result = $bookShelfService->updateBookFromUserBookShelf($userId, $bookId, $readNum, $readOffset);

        return response()->json($result);
    }

    /**
     * 获取书籍状态
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @return JsonResponse
     */
    public function getBookStateForBookShelf(BookShelfService $bookShelfService, $userId)
    {
        $booksState = $bookShelfService->getBooksStateByUserBookShelf($userId);

        return response()->json($booksState);
    }

    /**
     * 添加书籍到书架
     * @param Request $request
     * @param BookShelfService $bookShelfService
     * @param $userId
     * @param $bookId
     * @return JsonResponse
     */
    public function addBookForBookShelf(Request $request, BookShelfService $bookShelfService, $userId, $bookId)
    {
        $readNum = $request->input('readNum');
        $readOffset = $request->input('readOffset');
        $result = $bookShelfService->addBookIntoUserBookShelf($userId, $bookId, $readNum, $readOffset);

        return response()->json($result);
    }
}
