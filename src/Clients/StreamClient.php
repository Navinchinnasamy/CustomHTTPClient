<?php

namespace CustomHTTP\Clients;

use CustomHTTP\Interfaces\HttpClientInterface;

class StreamClient implements HttpClientInterface
{
    public String $baseUrl;
    private array $headers;
    private String $response;
    private $responseHeaders;

    public function checkAvailability()
    {
        if (in_array('http', stream_get_wrappers())) {
            return true;
        } else {
            return false;
        }
    }

    public function get(String $url, array $options = [])
    {
        $this->response = file_get_contents($url, false, $this->buildContext("GET", $options));
        return $this->handleResponse($http_response_header);
    }

    public function post(String $url, array $options = [])
    {
        $this->response = file_get_contents($url, false, $this->buildContext("POST", $options));
        return $this->handleResponse($http_response_header);
    }

    public function request(String $url, String $method, array $options = [])
    {
        $this->response = file_get_contents($url, false, $this->buildContext($method, $options));
        return $this->handleResponse($http_response_header);
    }

    private function buildContext($method, $options)
    {
        $options = [
            'http' => [
                'header' => $this->buildHeaders($options['headers']),
                'method' => $method,
                'content' => $options['body'] ? json_encode($options['body']) : null,
                'ignore_errors' => true
            ]
        ];
        $context = stream_context_create($options);
    }

    private function buildHeaders($headersAry)
    {
        foreach ($headersAry as $header => $value) {
            $this->headers[] = "$header:$value";
        }
    }

    protected function addHeaders(array $headers)
    {
        $this->buildHeaders($headers);
    }

    private function handleResponse($responseHeaders)
    {
        $this->responseHeaders = $responseHeaders;
        $statusLine = explode(' ', $responseHeaders[0]);
        $statusCode = intval($statusLine[1]);
        return [
            'status' => $statusCode,
            'headers' => $responseHeaders,
            'body' => is_string($this->response) ? json_decode($this->response) : $this->response
        ];
    }
}
