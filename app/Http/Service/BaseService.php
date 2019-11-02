<?php

namespace App\Http\Service;

use Grpc\BaseStub;
use Grpc\ChannelCredentials;

class BaseService extends BaseStub
{

    protected $hostname;
    protected $opts;
    protected $channel;

    public function __construct()
    {
        $this->hostname = ":8088";
        $this->opts = [
            'credentials' => ChannelCredentials::createInsecure()
        ];
        $this->channel = null;
        parent::__construct($this->hostname, $this->opts, $this->channel);
    }

    protected function callService($method, $params, $metadata = [], $options=[])
    {
        $this->_simpleRequest($method, $params, ['\Xuexitest\TestReply', 'decode'],
            $metadata, $options);
    }

}