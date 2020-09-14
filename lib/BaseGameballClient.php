<?php

namespace Gameball;

class BaseGameballClient implements GameballClientInterface
{
    /** @var string default base URL for Gameball's API */
    const DEFAULT_API_BASE = 'https://api.gameball.co/api/v2.0/';


    private $apiKey;
    private $transactionKey;
    private $apiBase;

    /**
     * Initializes a new instance of the {@link BaseGameballClient} class.
     *
     * The constructor takes three arguments (One optional). The arguments should be strings
     *
     *
     * @param string $apiKey
     * @param string $transactionKey
     * @param string $apiKey
     */
    public function __construct($apiKey , $transactionKey =null ,$apiBase=null)
    {

        $this->apiKey = $apiKey;
        $this->transactionKey = $transactionKey;
        $this->apiBase = $apiBase;
    }

    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }


    /**
     * Gets the transaction key used by the client to send requests.
     *
     * @return null|string the transaction key used by the client to send requests
     */
    public function getTransactionKey()
    {
        return $this->transactionKey;
    }


    /**
     * Gets the API Base URL used by the client to send requests.
     *
     * @return null|string the API Base URL used by the client to send requests
     */
    public function getApiBase()
    {
        if(!$this->apiBase)
        {
            return BaseGameballClient::DEFAULT_API_BASE;
        }
        return $this->apiBase;
    }

    /**
    * sets the apiKey for this client by the passed value
    */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
    * sets the transactionKey for this client by the passed value
    */
    public function setTransactionKey($transactionKey)
    {
        $this->transactionkey = $transactionKey;
    }

    /**
    * sets the apiBase for this client by the passed value
    */
    public function setApiBase($baseUrl)
    {
        $this->apiBase = $baseUrl;
    }


    /**
     * Sends a request to Gameball's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $headers the headers of the request
     * @param array $params the parameters of the request
     *
     * @return ApiResponse
     */
    public function request($method, $path, $headers, $params)
    {

        $baseUrl = $this->getApiBase();
        $requestor = new \Gameball\ApiRequestor($this->apiKeyForRequest(), $baseUrl);
        $response = $requestor->request($method, $path, $headers, $params );

        return $response;
    }

    /**
     * checks for the existence of ApiKey before the request takes place
     *
     * @throws \Gameball\Exception\GameballException
     *
     * @return string
     */
    private function apiKeyForRequest()
    {
        $apiKey = $this->getApiKey();

        if (null === $apiKey) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'GameballClient instance';

            throw new \Gameball\Exception\GameballException($msg);
        }

        return $apiKey;
    }

}
