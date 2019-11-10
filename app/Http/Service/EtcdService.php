<?php
namespace App\Http\Service;

use Aternos\Etcd\Client;
use Etcdserverpb\RangeRequest;

class EtcdService extends Client
{
    public function __construct($hostname = "localhost:2379", $username = false, $password = false)
    {
        parent::__construct($hostname, $username, $password);
    }

    public function getRange(string $key, $rangeEnd)
    {
        $client = $this->getKvClient();

        $request = new RangeRequest();
        $request->setKey($key);
        $request->setRangeEnd($rangeEnd);

        /** @var RangeResponse $response */
        list($response, $status) = $client->Range($request, $this->getMetaData())->wait();
        $this->validateStatus($status);

        $fields = $response->getKvs();

        if (count($fields) === 0) {
            return false;
        }

        $results = [];
        foreach ($fields as $field) {
            $results[] = $field->getValue();
        }

        return $results;
    }
}
