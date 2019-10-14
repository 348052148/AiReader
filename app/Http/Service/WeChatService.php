<?php
namespace App\Http\Service;


use GuzzleHttp\Client;

class WeChatService {

    private $appId = "wx271f2fd48e6af64b";
    private $secret = "b55ab89af5c591a426d40b3ca814146c";

    /**
     * 获取OPenid信息
     * @param $code
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOpenid($code)
    {
        $client = new Client();
        $url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
            $this->appId, $this->secret, $code);
        $res = $client->request('GET', $url);
        $body = $res->getBody();
        return json_decode($body->getContents(), true);
    }

    /**
     * 获取AccessToken
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccessToken()
    {
        $client = new Client();
        $url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",$this->appId, $this->secret);
        $res = $client->request('GET', $url);
        $body = $res->getBody();
        return json_decode($body->getContents(), true);
    }

    /**
     * 获取用户信息
     * @param $token
     * @param $openId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfo($token, $openId)
    {
        $url = sprintf("https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN", $token, $openId);
        $client = new Client();
        $res = $client->request('GET', $url);
        $body = $res->getBody();
        return json_decode($body->getContents(), true);
    }
}