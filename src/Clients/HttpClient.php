<?php

namespace CustomHTTP\Clients;

use CustomHTTP\Clients\CurlClient;
use CustomHTTP\Clients\SocketClient;
use CustomHTTP\Clients\StreamClient;

class HttpClient
{
    private array $clients = [
        'curl',
        'socket',
        'stream'
    ];
    private $client;

    public static function create(String $clientType)
    {
        switch ($clientType) {
            case 'curl':
                return new CurlClient();
            case 'stream':
                return new StreamClient();
            case 'socket':
                return new SocketClient();
            default:
                throw new \InvalidArgumentException("Unsupported HTTP client type: $clientType");
        }
    }

    public function getClient()
    {
        foreach ($this->clients as $client) {
            $class = 'CustomHTTP\\Clients\\' . ucfirst($client) . 'Client';
            $httpClient = new $class;
            $availablity = $httpClient->checkAvailability();
            if ($availablity) {
                return $httpClient;
                break;
            }
        }
        return false;
    }
}
