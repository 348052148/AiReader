<?php

namespace App\Listeners;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Events\SendSMSValidCode;
use Illuminate\Support\Facades\Log;

class SendSMSValidCodeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        AlibabaCloud::accessKeyClient(
            "LTAI4FfY34eJi1XdrU5h5YwY",
            "TkyyXsKN00jZrzSfGCIVz1NcaRE5Xa"
        )->regionId('cn-hangzhou')->asDefaultClient();
    }

    /**
     * Handle the event.
     *
     * @param SendSMSValidCode $event
     * @return void
     */
    public function handle(SendSMSValidCode $event)
    {
        try {
            AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $event->getPhoneNumber(),
                        'SignName' => "幽斋阅读",
                        'TemplateCode' => "SMS_181500978",
                        'TemplateParam' => "{'code':'{$event->getValidCode()}'}",
                    ],
                ])
                ->request();
        } catch (ClientException $e) {
            Log::error("发送短信客户端错误：", [$e->getMessage()]);
        } catch (ServerException $e) {
            Log::error("发送短信服务端错误：", [$e->getMessage()]);
        }
    }
}
