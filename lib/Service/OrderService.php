<?php

namespace Gameball\Service;


class OrderService extends \Gameball\Service\AbstractService
{

    /**
     * @param OrderRequest $orderRequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function sendOrder($orderRequest, $headers = null)
    {
        $transactionKey = $this->getClient()->getSecretKey();

        if ($headers)
            \array_push(
                $headers,
                'APIKey: ' . $this->getClient()->getApiKey(),
                'secretKey: ' . $this->getClient()->getSecretKey(),
                'Content-Type: application/json'
            );
        else
            $headers = array(
                'APIKey: ' . $this->getClient()->getApiKey(),
                'secretKey: ' . $this->getClient()->getSecretKey(),
                'Content-Type: application/json'
            );

        if (!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a secret key to do the request");


        if (!$orderRequest)
            throw new \Gameball\Exception\GameballException("Order Request object must be provided");

        $orderRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromOrderRequest($orderRequest);

        $response = $this->request('post', '/integrations/order', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }
}
