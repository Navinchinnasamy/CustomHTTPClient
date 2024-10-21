<?php

namespace CustomHTTP\Interfaces;

interface HttpClientInterface
{
    public function checkAvailability();
    public function get(String $url, array $options = []);
    public function post(String $url, array $options = []);
    public function request(String $url, String $method, array $options = []);
}
