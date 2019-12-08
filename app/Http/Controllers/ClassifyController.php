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
     * @param ClassifyService $classifyService
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifyList(Request $request, ClassifyService $classifyService)
    {
        $classifyList = $classifyService->getClassifyList();

        return response()->json($classifyList);
    }

    public function classifyMenus(Request $request, ClassifyService $classifyService)
    {
        $classifyMenus = $classifyService->getClassifyMenus();

        return response()->json($classifyMenus);
    }

    /**
     * 获取分类下书籍列表
     * @param Request $request
     * @param $classifyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifyBooks(Request $request, $classifyId)
    {
        $bookList = ClassifyService::getInstance()->getClassifyBookList($classifyId);

        return response()->json($bookList);
    }
}
