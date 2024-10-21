# Custom HTTP Client

A flexible HTTP client manager in PHP that allows you to choose between different HTTP clients, such as Guzzle and PHP Streams, based on your requirements.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Supported HTTP Clients](#supported-http-clients)
- [Examples](#examples)
- [License](#license)

## Installation

You can install this package using Composer. Run the following command in your terminal:

```bash
composer require navin/custom-http-client
```

## Usage

To use the Custom HTTP Client, you need to create an instance of the desired HTTP client using the **`HttpClientFactory`**. You can specify which client to use based or you can just get any one of the HTTP client available in your system/server.

```php
use CustomHTTP\HttpClientFactory;

$clientType = 'curl';
$httpClient = HttpClientFactory::create($clientType);

// Make a GET request
try {
    $response = $httpClient->get('https://example.com');
    echo $response;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

**OR**

```php
use CustomHTTP\HttpClientFactory;

$httpClient = new HttpClientFactory()->getClient();

// Make a GET request
try {
    $response = $httpClient->get('https://example.com');
    echo $response;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## Supported HTTP Clients
**PHP cURL:** A library that allows you to connect and communicate with different types of servers using various protocols, including HTTP.

**PHP Streams:** A built-in PHP method for handling HTTP requests using streams.

## Examples
Making a POST Request
Here's how to make a POST request using the custom HTTP client:
```php
try {
    $response = $httpClient->post('https://example.com/api', [
        'body' => [
            'key1' => 'value1',
            'key2' => 'value2',
        ],
        'headers' => [
            'api_key' => 'your-api-key'
        ]
    ]);
    echo $response;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```
Other methods can also be used as like below:

```php
try {
    $response = $httpClient->request('https://example.com/api', 'PUT', [
        'body' => [
            'key1' => 'value1',
            'key2' => 'value2',
        ],
        'headers' => [
            'api_key' => 'your-api-key'
        ]
    ]);
    echo $response;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## License
This project is licensed under the MIT License.


### Conclusion

Feel free to modify any sections to better suit your package's specifics or to include additional features and documentation as needed. If you need further customization or additional sections, let me know!

Mail ID: navinchinnasamy@gmail.com