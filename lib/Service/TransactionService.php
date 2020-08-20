<?php

namespace Gameball\Service;


class TransactionService extends \Gameball\Service\AbstractService
{

    /**
     * @param string $playerUniqueId
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getPlayerBalance($playerUniqueId,$headers = null)
    {
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
          $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $transactionKey = $this->getClient()->getTransactionKey();

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $params = array();
        $params['playerUniqueId'] = $playerUniqueId;


        $body = $playerUniqueId.":"."".":"."".":".$transactionKey;
        $bodyHashed = \sha1($body);
        $params['hash'] = $bodyHashed;

        $response = $this->request('post', '/integrations/transaction/balance', $headers, $params);


        if($response->isSuccess())
        {
            return $response;
        }
        else
        {
          $httpStatusCode = $response->code;

          $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
          $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
          throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
        }

    }




    /**
     * @param string $playerUniqueId
     * @param string $amount
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function holdPoints($playerUniqueId, $amount,$otp = null, $headers = null)
    {
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
        $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $transactionKey = $this->getClient()->getTransactionKey();

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$playerUniqueId || !$amount)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId and amount");

        $params = array();

        $params['playerUniqueId'] = $playerUniqueId;
        $params['amount'] = $amount;

        if($otp)
            $params['otp'] = $otp;

        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $params['transactionTime'] = $UTC_DateNow;

        $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);


        $body = $playerUniqueId.":".$yyMMddHHmmss.":".$amount.":".$transactionKey;
        $bodyHashed = \sha1($body);
        $params['hash'] = $bodyHashed;

        $response =  $this->request('post', '/integrations/transaction/hold', $headers, $params);

        if($response->isSuccess())
        {
            return $response;
        }
        else
        {
          $httpStatusCode = $response->code;

          $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
          $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
          throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
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
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
          $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

      $transactionKey = $this->getClient()->getTransactionKey();

      if(!$transactionKey)
          throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

      if(!$redeemPointsRequest)
          throw new \Gameball\Exception\GameballException("Redeem Points Request object cannot be null");

      $redeemPointsRequest->validate();

      $params = \Gameball\Util\ExtractingParameters::fromRedeemPointsRequest($redeemPointsRequest);

      $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
      $params['transactionTime'] = $UTC_DateNow;

      $playerUniqueId = $params['playerUniqueId'];
      $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);


      $body = $playerUniqueId.":".$yyMMddHHmmss.":".''.":".$transactionKey;
      $bodyHashed = \sha1($body);
      $params['hash'] = $bodyHashed;

      $response = $this->request('post', '/integrations/transaction/redeem', $headers, $params);

      if($response->isSuccess())
      {
          return $response;
      }
      else
      {
        $httpStatusCode = $response->code;

        $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
        $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
        throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
      }
    }



    /**
     * @param PlayerRequest $playerRequest
     * @param string $amount
     * @param string $transactionId
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function rewardPoints($playerRequest, $amount, $transactionId, $headers = null)
    {
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
          $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

      $transactionKey = $this->getClient()->getTransactionKey();

      if(!$transactionKey)
          throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

      if(!$playerRequest)
          throw new \Gameball\Exception\GameballException("PlayerRequest object must be provided");

      $playerRequest->validate();

      if(!is_numeric($amount))
          throw new \Gameball\Exception\GameballException("amount should be a numeric value");

      if(!$transactionId)
          throw new \Gameball\Exception\GameballException("Transaction ID must be provided");

      $params = \Gameball\Util\ExtractingParameters::fromPlayerRequest($playerRequest);
      $params['amount'] = $amount;
      $params['transactionId'] = $transactionId;

      $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
      $params['transactionTime'] = $UTC_DateNow;

      $playerUniqueId = $params['playerUniqueId'];
      $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);


      $body = $playerUniqueId.":".$yyMMddHHmmss.":".$amount.":".$transactionKey;
      $bodyHashed = \sha1($body);
      $params['hash'] = $bodyHashed;

      $response = $this->request('post', '/integrations/transaction/reward', $headers, $params);

      if($response->isSuccess())
      {
          return $response;
      }
      else
      {
        $httpStatusCode = $response->code;

        $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
        $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
        throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
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
    public function reverseTransaction($playerUniqueId, $transactionId, $reversedTransactionId, $headers = null)
    {
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
          $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

      $transactionKey = $this->getClient()->getTransactionKey();

      if(!$transactionKey)
          throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


      if(!$playerUniqueId)
          throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

      $params = array();
      $params['playerUniqueId'] = $playerUniqueId;

      if(!$transactionId)
          throw new \Gameball\Exception\GameballException("Must provide transactionId");
      $params['transactionId'] = $transactionId;

      if(!$reversedTransactionId)
          throw new \Gameball\Exception\GameballException("Must provide reversedTransactionId");
      $params['reversedTransactionId'] = $reversedTransactionId;

      $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
      $params['transactionTime'] = $UTC_DateNow;

      $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);


      $body = $playerUniqueId.":".$yyMMddHHmmss.":"."".":".$transactionKey;
      $bodyHashed = \sha1($body);
      $params['hash'] = $bodyHashed;

      $response =  $this->request('post', '/integrations/transaction/cancel', $headers, $params);
      if($response->isSuccess())
      {
          return $response;
      }
      else
      {
        $httpStatusCode = $response->code;

        $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
        $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
        throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
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
    public function reverseHold($playerUniqueId, $holdReference, $headers = null)
    {
      if($headers)
          \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
      else
          $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

      $transactionKey = $this->getClient()->getTransactionKey();

      if(!$transactionKey)
          throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


      if(!$playerUniqueId)
          throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

      $params = array();
      $params['playerUniqueId'] = $playerUniqueId;

      if(!$holdReference)
          throw new \Gameball\Exception\GameballException("Must provide holdReference");
      $params['holdReference'] = $holdReference;

      $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
      $params['transactionTime'] = $UTC_DateNow;

      $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);


      $body = $playerUniqueId.":".$yyMMddHHmmss.":"."".":".$transactionKey;
      $bodyHashed = \sha1($body);
      $params['hash'] = $bodyHashed;

      $response =  $this->request('post', '/integrations/transaction/hold', $headers, $params);

      if($response->isSuccess())
      {
          return $response;
      }
      else
      {
        $httpStatusCode = $response->code;

        $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
        $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
        throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
      }
    }

}
