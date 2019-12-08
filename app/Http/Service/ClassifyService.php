<?php

namespace App\Http\Service;

use App\Book;
use App\Classify;

class ClassifyService
{

    public function getClassifyList()
    {
        return Classify::all()->toArray();
    }

    public function getClassifyBookList($classifyId)
    {
        $bookList = Book::where("classify_id", $classifyId)->get()->toArray();

        return $bookList;
    }

    public function getClassifyMenus()
    {
        //古代言情
        //现代言情
        //仙侠言情
        //霸道总裁
        //军婚
        //宠文
        //女强
        //言情
        $classifyMenus = [
            [
                'title' => '全部',
                'active' => true
            ],
            [
                'title' => '男生',
                'menus' => [
                    [
                        'title' => '玄幻',
                        'flag' => 'man_xunhuan_url'
                    ],
                    [
                        'title' => '都市',
                        'flag' => 'man_dushi_url'
                    ],
                    [
                        'title' => '官场',
                        'flag' => 'man_guanchang_url'
                    ],
                    [
                        'title' => '乡村',
                        'flag' => 'man_xiangcun_url'
                    ],
                    [
                        'title' => '仙侠',
                        'flag' => 'man_xianxia_url'
                    ],
                    [
                        'title' => '军事',
                        'flag' => 'man_junshi_url'
                    ],
                    [
                        'title' => '网游',
                        'flag' => 'man_wangyou_url'
                    ],
                    [
                        'title' => '历史',
                        'flag' => 'man_lishi_url'
                    ],
                ]
            ],
            [
                'title' => '女生',
                'menus' => [
                    [
                        'title' => '古代言情',
                        'flag' => 'women_gudaiyanqing_url'
                    ],
                    [
                        'title' => '现代言情',
                        'flag' => 'women_xiandaiyanqing_url'
                    ],
                    [
                        'title' => '仙侠言情',
                        'flag' => 'women_xianxiayanqing_url'
                    ],
                    [
                        'title' => '霸道总裁',
                        'flag' => 'women_badaozongcai_url'
                    ],
                    [
                        'title' => '军婚',
                        'flag' => 'women_junhun_url'
                    ],
                    [
                        'title' => '宠文',
                        'flag' => 'women_chongwen_url'
                    ],
                    [
                        'title' => '女强',
                        'flag' => 'women_nvqiang_url'
                    ],
                    [
                        'title' => '言情',
                        'flag' => 'women_yanqing_url'
                    ],
                ]
            ],
            [
                'title' => '耽美',
                'menus' => [
                    [
                        'title' => '古风耽美',
                        'flag' => 'zm_xiandaizm_url'
                    ],
                    [
                        'title' => '现代耽美',
                        'flag' => 'zm_gufenzm_url'
                    ],
                    [
                        'title' => '强攻强受',
                        'flag' => 'zm_qgqs_url'
                    ],
                    [
                        'title' => '耽美同人',
                        'flag' => 'zm_zmtr_url'
                    ],
                ]
            ]
        ];
        return $classifyMenus;
    }

}