<?php

namespace Gameball;


use Gameball\Exception;
/**
 * Class ApiRequestor that is responsible for calling the API on behalf of the service
 */
class ApiRequestor
{
    /**
     * @var null|string
     */
    private $_apiKey;

    /**
     * @var null|string
     */
    private $_apiBase;

    /**
     * @var HttpClient\ClientInterface
     */
    private static $_httpClient;



    /**
     * ApiRequestor constructor.
     *
     * @param null|string $apiKey
     * @param null|string $apiBase
     */
    public function __construct($apiKey, $apiBase)
    {
        $this->_apiKey = $apiKey;

        $this->_apiBase = $apiBase;
        self::$_httpClient = HttpClient\CurlClient::instance();
    }



    /**
     * @param string     $method
     * @param string     $path
     * @param null|array $headers
     * @param null|array $params
     *
     * @throws Exception\GameballException
     *
     * @return array ApiReponse
     */
    public function request($method, $path, $headers = null, $params = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];

        list($rbody, $rcode, $rheaders) =
        $this->_requestRaw($method, $path, $headers, $params);
        $decodedJson = $this->_interpretResponse($rbody);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $decodedJson);

        return $resp;
    }



    /**
     * @param string $method
     * @param string $path
     * @param array $headers
     * @param array $params
     *
     * @throws Exception\GameballException
     *
     * @return array
     */
    private function _requestRaw($method, $path, $headers, $params)
    {
        $myApiKey = $this->_apiKey;


        if (!$myApiKey) {
            $msg = 'No API key provided.';

            throw new Exception\GameballException($msg);
        }

        $absUrl = $this->_apiBase . $path;

        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $headers,
            $params
        );

        return [$rbody, $rcode, $rheaders];
    }


    /**
     * @param string $rbody
     *
     * @return array
     */
    private function _interpretResponse($rbody)
    {

        $start = \strpos($rbody , '{');
        $rbody = \substr($rbody,$start);

        $resp = \json_decode($rbody, true);
        return $resp;
    }

    /**
     * @static
     *
     * @param HttpClient\ClientInterface $client
     */
    public static function setHttpClient($client)
    {
        self::$_httpClient = $client;
    }


    /**
     * @return HttpClient\ClientInterface
     */
    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = HttpClient\CurlClient::instance();
        }

        return self::$_httpClient;
    }
}
