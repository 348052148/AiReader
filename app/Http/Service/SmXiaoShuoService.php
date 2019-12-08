<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\parse_query;

class SmXiaoShuoService
{

    public static function soarBooks($page = 1)
    {
        return self::parseContents(config('services.sm.soar_url'));
    }

    public static function hotBooks($page = 1)
    {
        return self::parseContents(config('services.sm.soar_url'));
    }

    public static function ManXuanhuanBooks($page = 1)
    {
        return self::parseContents(config('services.sm.man_xunhuan_url'), $page);
    }

    public static function ManDushiBooks($page = 1)
    {
        return self::parseContents(config('services.sm.man_dushi_url'), $page);
    }

    public static function ManGuanChangBooks($page = 1)
    {
        //man_guanchang_url
        return self::parseContents(config('services.sm.man_guanchang_url'), $page);
    }

    public static function ManXianCunBooks($page = 1)
    {
        //man_xiangchun_url
        return self::parseContents(config('services.sm.man_xiangcun_url'), $page);
    }

    public static function ManXianXiaBooks($page = 1)
    {
        //man_xianxia_url
        return self::parseContents(config('services.sm.man_xianxia_url'), $page);
    }

    public static function ManJunShiBooks($page = 1)
    {
        //man_junshi_url
        return self::parseContents(config('services.sm.man_junshi_url'), $page);
    }

    public static function ManWangYouBooks($page = 1)
    {
        //man_wangyou_url
        return self::parseContents(config('services.sm.man_wangyou_url'), $page);
    }

    public static function ManLiShiBooks($page = 1)
    {
        //man_lishi_url
        return self::parseContents(config('services.sm.man_lishi_url'), $page);
    }

    public static function getSMXiaoShuoBooks($flag, $page = 1, $size = 10)
    {
        return self::parseContents(config(sprintf('services.sm.%s', $flag)), $page, $size);
    }

    private static function parseContents($url, $page = 1, $size = 10)
    {
        $url = str_replace("{page}", $page, $url);
        $urlPath = parse_url($url);
        $query = parse_query($urlPath['query']);
        //解析
        $client = new Client();
        $response = $client->get($url);
        $result = $response->getBody()->getContents();
        $books = [];
        $result = str_replace("{$query['callback']}(", "", $result);
        $result = str_replace(");", "", $result);
        $result = json_decode($result, true);
        foreach ($result['list'] as $book) {
            $books [] = [
                'book_id' => md5($book['title'] . $book['author']),
                'title' => $book['title'],
                'cover' => $book['icon'],
                'author' => $book['author'],
                'desc' => $book['description']
            ];
        }
        return $books;
    }
}
