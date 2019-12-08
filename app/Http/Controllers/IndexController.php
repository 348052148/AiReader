<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Service\BaseService;
use App\Http\Service\BookService;
use App\Jobs\StoreChapterContentsJob;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\parse_query;

class IndexController extends Controller
{
    //

    public function index(BookService $bookService)
    {
        $req = parse_url(config('services.sm.bao_url'));
        var_dump(parse_query($req['query']));
//        $client = new Client();
//        $response = $client->get('https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page=3&size=20&q=%E7%83%AD%E6%90%9C&_t=1575719226479&_=1575719226480&callback=jsonp3');
//        $result = $response->getBody()->getContents();
//
//        foreach ($result['list'] as $book){
//            [
//                'id' => md5($book['title'].$book['author']),
//                'title' => $book['title'],
//                'cover' => $book['icon'],
//                'author' => $book['author'],
//                'desc' => $book['description']
//            ];
//        }
//        $client = new \Baidu\AipOcr('17842200', 'ucBAdlp7GKr65iKl6HcnAfyT', 'kI88KrdAIyLexQlvE9kp9VG2EFMHGLOx');
//        $image = file_get_contents(storage_path('代码.png'));

// 调用通用文字识别, 图片参数为本地图片
//        $res=$client->basicGeneral($image);
//        var_dump($res);
//        $c = new BaseService();
//        $c->fundService();
//        $bookList = Book::where("title","like","%天启预报%")->get()->toArray();
//        var_dump($bookList);
//        echo md5("神级大魔头拉姆连载");
//        $chapters = $bookService->getBookChapters('0202b04d8aebd2afc56c586fcd228b87');
//        return response()->json($chapters);
    }

    /**
     * 聚合首页推荐热门数据
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function homeBooks(BookService $bookService)
    {
        $hotBooks = $bookService->getHotBooks();
        $recommendBooks = $bookService->getRecommendBooks();
        $banarList = [
            [
                'title' => '推荐书籍',
                'img' => 'https://sta-op.douyucdn.cn/nggsys/2019/10/16/e5e1d8fdac31df37f638d678903410be.jpg',
                'link' => ''
            ],
            [
                'title' => '书籍',
                'img' => 'https://images.unsplash.com/photo-1551214012-84f95e060dee?w=1200',
                'link' => ''
            ]
        ];

        return response()->json([
            'hot' => $hotBooks,
            'recommend' =>  $recommendBooks,
            'bannars' =>$banarList,
        ]);
    }

    /**
     * 展示橱窗
     * @param Request $request
     * @return JsonResponse
     */
    public function bannarBooks(Request $request)
    {
        $banarList = [
            [
                'title' => '推荐书籍',
                'img' => 'https://sta-op.douyucdn.cn/nggsys/2019/10/16/e5e1d8fdac31df37f638d678903410be.jpg',
                'link' => ''
            ],
            [
                'title' => '书籍',
                'img' => 'https://images.unsplash.com/photo-1551214012-84f95e060dee?w=1200',
                'link' => ''
            ]
        ];
        return response()->json($banarList);
    }

    /**
     * 热门书籍
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function hotBooks(BookService $bookService)
    {
        $hotBooks = $bookService->getHotBooks();

        return response()->json($hotBooks);
    }

    /**
     * 推荐书籍
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function recommendBooks(BookService $bookService)
    {
        $recommendBooks = $bookService->getRecommendBooks();

        return response()->json($recommendBooks);
    }
}
