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
            ]
        ]);
    }
}
