<?php

use Illuminate\Database\Seeder;

class ClassifysTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('w_classifys')->insert([
            [
                'title' => "玄幻魔法",
                'classify_id' => 1,
            ],
            [
                'title' => "武侠修真",
                'classify_id' => 2,
            ],
            [
                'title' => "纯爱耽美",
                'classify_id' => 3,
            ],
            [
                'title' => "都市言情",
                'classify_id' => 4,
            ],
            [
                'title' => "职场校园",
                'classify_id' => 5,
            ],
            [
                'title' => "穿越重生",
                'classify_id' => 6,
            ],
            [
                'title' => "历史军事",
                'classify_id' => 7,
            ],
            [
                'title' => "网游动漫",
                'classify_id' => 8,
            ],
            [
                'title' => "恐怖灵异",
                'classify_id' => 9,
            ],
            [
                'title' => "科幻小说",
                'classify_id' => 10,
            ],
            [
                'title' => "美文名著",
                'classify_id' => 11,
            ]
        ]);
    }
}

/**
 * - 男生
 *  21 奇幻玄幻
 *  22 仙侠武侠
 *  23 都市小说
 *  24 历史军事
 *  25 游戏竞技
 *  26 科幻末世
 *- 女生
 *  31 都市言情
 *  32 古装言情
 *  33 幻想言情
 *  34 浪漫青春
 *- 个性化
 *  41 悬疑小说
 *  42 二次元
 *  43 爆笑小说
 *  44 自述小说
 *  45 青春小说
 *  46 情感小说
 */