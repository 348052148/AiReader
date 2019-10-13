<?php

namespace App\Http\Controllers;

use App\Http\Parser\QuanWenParser;
use App\Http\Service\ClassifyService;
use Illuminate\Http\Request;

class ClassifyController extends Controller
{
    /**
     * 获取分类列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifyList(Request $request, ClassifyService $classifyService)
    {
        $classifyList = $classifyService->getClassifyList();

        return response()->json($classifyList);
    }

    /**
     * 获取分类下书籍列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifyBooks(Request $request, $classifyId)
    {
        $bookList = ClassifyService::getInstance()->getClassifyBookList($classifyId);

        return response()->json($bookList);
    }
}
