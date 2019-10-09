<?php
namespace App\Http\Service;


class TextHandleService {

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

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