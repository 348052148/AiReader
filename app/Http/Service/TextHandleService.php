<?php
namespace App\Http\Service;


class TextHandleService {

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
        return $txtData;
    }
}