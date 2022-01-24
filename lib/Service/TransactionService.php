<?php

namespace Gameball\Service;


class TransactionService extends \Gameball\Service\AbstractService
{

    
    /**
     * @param string $playerUniqueId
     * @param string $amount
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function holdPoints($playerUniqueId, $amount, $otp = null, $email = null, $mobile = null, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if (!$playerUniqueId || !$amount)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId and amount");

        $params = array();

        $params['playerUniqueId'] = $playerUniqueId;
        $params['amount'] = $amount;


        if (isset($email) && !is_null($email)) {
            $params['email'] = $email;
        }
        
        if (isset($mobile) && !is_null($mobile)) {
            $params['mobile'] = $mobile;
        }

        // if($otp)
        //     $params['otp'] = $otp;

        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))) . 'Z';
        $params['transactionTime'] = $UTC_DateNow;

        $response =  $this->request('post', '/integrations/transaction/hold', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }


    /**
     * @param RedeemPointsRequest $redeemPointsrequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function redeemPoints($redeemPointsRequest, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if (!$redeemPointsRequest)
            throw new \Gameball\Exception\GameballException("Redeem Points Request object cannot be null");

        $redeemPointsRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromRedeemPointsRequest($redeemPointsRequest);

        $response = $this->request('post', '/integrations/transaction/redeem', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }



    /**
     * @param PlayerRequest $playerRequest
     * @param string $amount
     * @param string $transactionId
     * @param null|Merchant $merchant
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function cashback($cashbackRequest, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        $params = \Gameball\Util\ExtractingParameters::fromCashbackRequest($cashbackRequest);


        $response = $this->request('post', '/integrations/transaction/cashback', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }

       /**
     * @param ManualTransactionRequest $manualTransactionRequest
     * @param string $amount
     * @param string $transactionId
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function manualTransaction($manualTransactionRequest, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        $params = \Gameball\Util\ExtractingParameters::fromManualTransactionRequest($manualTransactionRequest);

        $response = $this->request('post', '/integrations/transaction/manual', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }



    /**
     * @param string $playerUniqueId
     * @param string $transactionId
     * @param string $reversedTransactionId
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function refund($playerUniqueId, $transactionId, $reversedTransactionId, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        if (!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $params = array();
        $params['playerUniqueId'] = $playerUniqueId;

        if (!$transactionId)
            throw new \Gameball\Exception\GameballException("Must provide transactionId");
        $params['transactionId'] = $transactionId;

        if (!$reversedTransactionId)
            throw new \Gameball\Exception\GameballException("Must provide reversedTransactionId");
        $params['reversedTransactionId'] = $reversedTransactionId;

        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))) . 'Z';
        $params['transactionTime'] = $UTC_DateNow;

        $response =  $this->request('post', '/integrations/transaction/refund', $headers, $params);
        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }


    /**
     * @param string $playerUniqueId
     * @param string $transactionId
     * @param string $reversedTransactionId
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function listTransactions(
        $page = 1,
        $limit = 50,
        $direction = null,
        $from = null,
        $to = null,
        $transactionId = null,
        $status = null,
        $headers = null
    ) {
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        if ($direction) {
            if (!in_array($direction, ['+', '-']))
                throw new \Gameball\Exception\GameballException("Invalid Direction Parameter, should be either + or -");
        }

        $params = array(
            'page' => $page,
            'limit' => $limit,
            'direction' => $direction,
            'from' => $from,
            'to' => $to,
            'transactionId' => $transactionId,
            'status' => $status
        );

        $response =  $this->request('get', '/integrations/transaction/list', $headers, $params);

        if ($response->isSuccess()) {
            return $response;
        } else {
            $httpStatusCode = $response->code;

            $gameballCode = isset($response->decodedJson['code']) ? $response->decodedJson['code'] : null;
            $message = isset($response->decodedJson['message']) ? $response->decodedJson['message'] : null;
            throw \Gameball\Exception\GameballException::factory($message, $httpStatusCode, $gameballCode);
        }
    }



    /**
     * @param string $playerUniqueId
     * @param string $holdReference
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function reverseHold($playerUniqueId, $holdReference, $email = null, $mobile = null, $headers = null)
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
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        if (!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $params = array();
        $params['playerUniqueId'] = $playerUniqueId;

        if (isset($email) && !is_null($email)) {
            $params['email'] = $email;
        }

        if (isset($mobile) && !is_null($mobile)) {
            $params['mobile'] = $mobile;
        }

        if (!$holdReference)
            throw new \Gameball\Exception\GameballException("Must provide holdReference");

        $response =  $this->request('delete', "/integrations/transaction/hold/{$holdReference}", $headers, $params);

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
