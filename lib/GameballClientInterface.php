<?php

namespace Gameball;

/**
 * Interface for a Gameball client.
 */
interface GameballClientInterface
{
    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey();

    /**
     * Gets the Transaction key used by the client to send requests.
     *
     * @return null|string the transaction key used by the client to send requests
     */
    public function getTransactionKey();


    /**
     * Gets the API Base URL used by the client to send requests.
     *
     * @return null|string the API Base URL used by the client to send requests
     */
    public function getApiBase();

    /**
    * sets the apiKey for this client by the passed value
    */
    public function setApiKey($apiKey);

    /**
    * sets the transactionKey for this client by the passed value
    */
    public function setTransactionKey($transactionKey);

    /**
    * sets the apiBase for this client by the passed value
    */
    public function setApiBase($baseUrl);

    /**
     * Sends a request to Gameball's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     *@param array $params the headers of the request
     * @param array $params the parameters of the request
     *
     */
    public function request($method, $path, $headers, $params);
}
