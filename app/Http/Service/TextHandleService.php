<?php

namespace App\Http\Service;


class TextHandleService
{

    /**
     * 解析内容数据
     * @param $txtData
     * @return mixed
     */
    public function ParserText($txtData)
    {
        $txtData = str_replace("\n", "<br>", $txtData);
        $txtData = str_replace("style5();", "", $txtData);
        $txtData = str_replace("style6();", "", $txtData);
        $txtData = preg_replace("/亲,点击进去,给个好评呗,分数越高更新越快\S*?无广告清新阅读！/",
            "<br>", $txtData);
        $txtData .= <<< EOL
            <h5>
            本程序所有小说均为转载作品，所有章节均由网友上传，本程序只是为了宣传本书让更多读者欣赏，
            并减少读者在书籍搜索过程中的不便。<br>
            支持正版, 请到正版网站购买正版书籍观看。
            </h5>
EOL;

        return $txtData;
    }
}