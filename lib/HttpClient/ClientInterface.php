<?php

namespace Gameball\HttpClient;

interface ClientInterface
{
    /**
     * @param string $method The HTTP method being used
     * @param string $absUrl The URL being requested, including domain and protocol
     * @param array $headers array of Headers to be used in the request (full strings, not KV pairs)
     * @param array $params KV pairs for parameters. Can be nested for arrays
     *
     *
     * @return array an array whose first element is response body, second
     *    element is HTTP status code and third array of HTTP response headers
     *
     * @throws \Gameball\Exception\GameballException
     */
     public function request($method, $absUrl, $headers, $params);
}
?>
