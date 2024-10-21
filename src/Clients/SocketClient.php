<?php

namespace CustomHTTP\Clients;

use CustomHTTP\Interfaces\HttpClientInterface;

class SocketClient implements HttpClientInterface
{
    public String $baseUrl;
    private array $headers;
    private String $response;

    public function get(String $url, array $options = []) {}
    public function post(String $url, array $options = []) {}
    public function request(String $url, String $method, array $options = []) {}

    public function checkAvailability()
    {
        if (function_exists('fsockopen')) {
            return true;
        } else {
            return false;
        }
    }
}
