<?php

namespace CustomHTTP;

class CustomHTTPClient
{
    private String $baseUrl;
    private array $headers;
    private String $response;

    public function __construct(String $baseUrl = '')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function request(String $method, String $endpoint, array $headers = [], array $body = null)
    {
        $url = $this->baseUrl ? $this->baseUrl . '/' . ltrim($endpoint) : $endpoint;
        $options = [
            'http' => [
                'header' => $this->buildHeaders($headers),
                'method' => $method,
                'content' => $body ? json_encode($body) : null,
                'ignore_errors' => true
            ]
        ];
        $context = stream_context_create($options);
        $this->response = file_get_contents($url, false, $context);
        return $this->handleResponse($http_response_header);
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
        $statusLine = explode(' ', $responseHeaders[0]);
        $statusCode = intval($statusLine[1]);
        return [
            'status' => $statusCode,
            'headers' => $responseHeaders,
            'body' => is_string($this->response) ? json_decode($this->response) : $this->response
        ];
    }
}
