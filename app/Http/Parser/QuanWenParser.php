<?php
namespace App\Http\Parser;

use App\Book;
use App\Http\Service\Catalog;
use App\Http\Service\Classfly;
use QL\QueryList;

class QuanWenParser  implements IParser {

    /**
     * 获取书籍详细信息
     * @param $url
     * @return Book
     */
    public static function convertBook($url)
    {
        $rules = [
            'title' => ['.b-info>h1', 'text'],
            'detail' => ['.b-info .infoDetail #waa', 'text'],
            'status' => ['.author .bookDetail dl:eq(0) dd', 'text'],
            'author' => ['.author .bookDetail dl:eq(1) dd', 'text'],
            'url' => ['.b-oper .reader', 'href'],
            'coverImg' => ['.detail>a>img', 'src'],
        ];
        $rt = QueryList::get($url)->rules($rules)->query()->getData();

        $rt = $rt[0];

        return new Book(iconv('gbk', 'utf-8',$rt['title']),'',iconv('gbk', 'utf-8',$rt['author']),
            iconv('gbk', 'utf-8',$rt['status']),$rt['coverImg'],iconv('gbk', 'utf-8',$rt['detail']), $rt['url']);
    }

    /**
     * 获得书籍章节目录
     * @param $url
     * @return array
     */
    public static function convertCatelogs($url)
    {
        $rules = [
            'title' => ['.chapterNum ul li','text'],
            'url'   => ['.chapterNum ul li>a', 'href']
        ];
        //$url = "http://www.quanshuwang.com/book/0/567";
        $rts = QueryList::get($url)->rules($rules)->query()->getData();

        $catelogs = [];
        foreach ($rts  as $i => $rt) {
            $catelogs[] = new Catalog(iconv('gbk', 'utf-8',$rt['title']), $i, $rt['url']);
        }

        return $catelogs;
    }

    /**
     * 获取章节内容
     * @param $url
     * @return mixed
     */
    public static function convertCatelogContents($url)
    {
        return QueryList::get($url)->find(".mainContenr")->text();
    }

    /**
     * 获得查询书籍列表
     * @param $keyword
     * @return array
     */
    public static function convertSearchBooks($keyword, $page)
    {
        $rules = [
            'url' => ['.board-list-collapse ul li>a', 'href'],
            'coverImg' => ['.board-list-collapse li>a>img', 'src'],
            'title' => ['.board-list-collapse li>span .stitle)', 'text'],
            'author' => ['.board-list-collapse>ul>li>span>a:eq(1)', 'text'],
            'detail' => ['.board-list-collapse li>span>em', 'text'],
        ];
        $keyword = iconv('utf-8','gbk',$keyword );
        $url = "http://www.quanshuwang.com/modules/article/search.php?searchkey={$keyword}&searchtype=articlename&searchbuttom.x=3&searchbuttom.y=28&page={$page}";
        $rts = QueryList::get($url)->rules($rules)->query()->getData();
        $books = [];
        foreach ($rts  as $rt) {
            $books[] = new Book(iconv('gbk', 'utf-8',$rt['title']),'',"",
                "",$rt['coverImg'],iconv('gbk', 'utf-8',$rt['detail']), $rt['url']);
        }

        return $books;
    }


    /**
     * 获取小说分类
     * @param $url
     * @return array
     */
    public static function convertClassflys($url = 'http://www.quanshuwang.com/')
    {
        $rules = [
            'url' => ['.channel-nav ul li>a', 'href'],
            'title' => ['.channel-nav ul li>a', 'text'],
        ];
        $rts = QueryList::get($url)->rules($rules)->query()->getData();
        $classflys = [];
        foreach ($rts as $rt){
            $classflys[] = new Classfly(iconv('gbk', 'utf-8', $rt['title']), $rt['url']);
        }

        return $classflys;
    }

    /**
     * 按分类搜索小说
     * @param $url
     * @return array
     */
    public static function convertSearchClassfly($url, $page)
    {
        $rules = [
            'url' => ['.board-list-collapse ul li>a', 'href'],
            'coverImg' => ['.board-list-collapse li>a>img', 'src'],
            'title' => ['.board-list-collapse li>span .stitle)', 'text'],
            'author' => ['.board-list-collapse>ul>li>span>a:eq(1)', 'text'],
            'detail' => ['.board-list-collapse li>span>em', 'text'],
        ];

        $rts = QueryList::get($url."?page={$page}")->rules($rules)->query()->getData();
        $books = [];
        foreach ($rts as $rt) {
            $books[] = new Book(iconv('gbk', 'utf-8',$rt['title']),'','',
                '',$rt['coverImg'],iconv('gbk', 'utf-8',$rt['detail']), $rt['url']);
        }

        return $books;
    }

}