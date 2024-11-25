<?php

namespace Mmrocket\MmrocketSdkPhp\Http;

interface HttpClientInterface
{
    public function request($method, $absoluteUrl, $params = [], $headers = []); 
}