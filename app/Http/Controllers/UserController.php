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
