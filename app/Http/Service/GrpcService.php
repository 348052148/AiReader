<?php

namespace App\Http\Service;

use Grpc\BaseStub;
use Grpc\ChannelCredentials;
use Illuminate\Support\Facades\Log;

class GrpcService extends BaseStub
{

    protected $hostname;
    protected $opts;
    protected $channel;

    public function __construct()
    {
        $host = config('services.gorpc.domain');
        $port = config('services.gorpc.port');
        $this->hostname = "{$host}:{$port}";
        $this->hostname = $this->fundService();
        Log::info("goRpc", [$this->hostname]);
        $this->opts = [
            'credentials' => ChannelCredentials::createInsecure()
        ];
        $this->channel = null;
        parent::__construct($this->hostname, $this->opts, $this->channel);
    }

    private static $staticInstance = null;
    public static function getInstance()
    {
        if (self::$staticInstance == null) {
            self::$staticInstance =  new self();
        }
        return self::$staticInstance;
    }

    public function fundService()
    {
        $client = new EtcdService(config('services.etcd.host') . ":" . config('services.etcd.port'));
        $services = $client->getRange(config("services.gorpc.keys"), config("services.gorpc.keys") . "9000");
        $len = count($services);
        $index = random_int(0, $len - 1);

        return $services[$index];
    }

    public static function simpleRequest($method, $argument, $deserialize, array $metadata = [], array $options = [])
    {
        return self::getInstance()->_simpleRequest($method, $argument, $deserialize, $metadata, $options);
    }

}