<?php

namespace Mmrocket\MmrocketSdkPhp\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mmrocket\MmrocketSdkPhp\Exceptions\MmRocketException;

class GuzzleClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?? new Client(['http_errors' => false]);
    }

    public function request($method, $url, $params = [], $headers = [])
    {
        try {
            $response = $this->client->request($method, $url, [
                'headers' => $headers,
                'json' => $params
            ]);
        } catch (\Exception $exception) {
            throw new MmRocketException("HTTP request failed: {$url} " . $exception->getMessage(), 500, $exception);
        }

        return new ApiResponse(
            $response->getStatusCode(),
            (string) $response->getBody(),
            $response->getHeaders(),
            [
                'headers'     => $headers,
                'form_data'   => $params,
                'url'         => $url,
                'method'      => strtoupper($method)
            ]
        );
    }
}
