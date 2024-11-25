<?php

namespace Mmrocket\MmrocketSdkPhp;

use GuzzleHttp\ClientInterface;
use Mmrocket\MmrocketSdkPhp\Http\GuzzleClient;
use Mmrocket\MmrocketSdkPhp\Exceptions\MmRocketException;

class MmRocketSdkPhp extends GuzzleClient
{
    const BASE_URL = 'https://api.hashgraph1.io';
    private $headers = [];
    const BLOCKCHAIN = [
        "bsc",
        "eth",
        "blast",
        "base"
    ];
    public function __construct(string $apiKey, ClientInterface $client = null)
    {
        parent::__construct($client);
        $this->headers['Authorization'] = $apiKey;
    }

    public function getTransaction(string $chainCode, int $limit, int $page)
    {
        if (!in_array($chainCode, self::BLOCKCHAIN)) {
            throw new MmRocketException("Chaincode do not support");
        }
        $url = $this->requestUrl('getTransaction', ['chain_code' => $chainCode, 'limit' => $limit, 'page' => $page]);
        return $this->request('get', $url, [], $this->headers);
    }

    public function addWatchedAddress(string $chainCode, array $addresses)
    {
        if (!in_array($chainCode, self::BLOCKCHAIN)) {
            throw new MmRocketException("Chaincode do not support");
        }

        if (!is_array($addresses) || count($addresses) <= 0) {
            throw new MmRocketException("address is array");
        }

        $url = $this->requestUrl('addWatchedAddress');
        return $this->request('post', $url, ['chain_code' => $chainCode, 'addresses' => $addresses], $this->headers);
    }

    public function removeWatchedAddress(string $chainCode, array $addresses)
    {
        if (!in_array($chainCode, self::BLOCKCHAIN)) {
            throw new MmRocketException("Chaincode do not support");
        }

        if (!is_array($addresses) || count($addresses) <= 0) {
            throw new MmRocketException("address is array");
        }

        $url = $this->requestUrl('removeWatchedAddress');
        return $this->request('post', $url, ['chain_code' => $chainCode, 'addresses' => $addresses], $this->headers);
    }

    protected function requestUrl(string $endpointName, array $params = []): string
    {
        switch ($endpointName) {
            case 'getTransaction':
                $urlSegment = '/api/v1/transaction/get?' . http_build_query($params);
                break;
            case 'addWatchedAddress':
                $urlSegment = '/api/v1/transaction/alert/add';
                break;
            case 'removeWatchedAddress':
                $urlSegment = '/api/v1/transaction/alert/remove';
                break;
            default:
                throw new MmRocketException("Unknown Api endpoint - {$endpointName}.");
                break;
        }

        return self::BASE_URL . $urlSegment;
    }
}
