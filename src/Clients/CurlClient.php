<?php

namespace CustomHTTP\Clients;

use CustomHTTP\Interfaces\HttpClientInterface;

class CurlClient implements HttpClientInterface
{
    public String $baseUrl;
    private array $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_ENCODING       => "utf-8",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_VERBOSE        => 1,
    ];
    private $responseHeaders;
    private array $response;

    public function get(String $url, array $options = [])
    {
        $this->response = $this->makeHttpCall($url);
        return $this->handleResponse();
    }

    public function post(String $url, array $options = [])
    {
        $options = $this->stringifyBody($options);
        $this->options[CURLOPT_POST] = true;
        $this->options[CURLOPT_POSTFIELDS] = $options['body'] ?? null;
        $this->options[CURLOPT_HTTPHEADER] = $options['headers'] ?? [];
        $this->response = $this->makeHttpCall($url);
        return $this->handleResponse();
    }

    public function request(String $url, String $method, array $options = [])
    {
        if ("post" === strtolower($method)) {
            $options = $this->stringifyBody($options);
            $this->options[CURLOPT_POSTFIELDS] = $options['body'] ?? null;
            $this->options[CURLOPT_HTTPHEADER] = $options['headers'] ?? [];
        }
        $this->response = $this->makeHttpCall($url);
        return $this->handleResponse();
    }

    public function checkAvailability()
    {
        if (function_exists('curl_version')) {
            return true;
        } else {
            return false;
        }
    }

    private function stringifyBody($options)
    {
        if (is_array($options['body'])) {
            $options['body'] = json_encode($options['body']);
        }
        return $options;
    }

    private function makeHttpCall($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, $this->options);
        $data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!curl_errno($ch)) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $this->responseHeaders = substr($data, 0, $header_size);
            $data = substr($data, $header_size);
        }
        return ["body" => $data, "status_code" => $statusCode, "error_code" => $curl_errno, "error_msg" => $curl_error];
    }

    private function handleResponse()
    {
        return [
            'status' => intval($this->response['status_code']),
            'body' => is_string($this->response['body']) ? json_decode($this->response['body']) : $this->response['body'],
            'error' => $this->response['error_msg'],
            'error_code' => $this->response['error_code']
        ];
    }
}
