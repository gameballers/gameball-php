<?php

namespace Gameball\Service;


class CouponService extends \Gameball\Service\AbstractService
{

    /**
     * @param CreateCouponRequest $createCouponRequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function createCoupon($createCouponRequest, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $transactionKey = $this->getClient()->getSecretKey();

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$createCouponRequest)
            throw new \Gameball\Exception\GameballException("CreateCouponRequest object must be provided");

        $createCouponRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromCreateCouponRequest($createCouponRequest);

        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $params['transactionTime'] = $UTC_DateNow;

        $playerUniqueId = $params['playerUniqueId'];

        // NOTE: transactionTime not included in the Hash ($yyMMddHHmmss)

        $body = $playerUniqueId.":"."".":"."".":".$transactionKey;
        $bodyHashed = \sha1($body);

        $params['hash'] = $bodyHashed;

        $response = $this->request('post', '/integrations/coupon', $headers, $params);

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
     * @param string $code
     * @param null|array $headers
     *
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function redeemCoupon($playerUniqueId, $code=null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $transactionKey = $this->getClient()->getSecretKey();

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");



        $params = array();

        $params['playerUniqueId'] = $playerUniqueId;

        if($code)
            $params['code'] = $code;

        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $params['transactionTime'] = $UTC_DateNow;

        // NOTE: transactionTime not included in the Hash ($yyMMddHHmmss)

        $body = $playerUniqueId.":"."".":"."".":".$transactionKey;
        $bodyHashed = \sha1($body);

        $params['hash'] = $bodyHashed;

        $response = $this->request('post', '/integrations/coupon/redeem', $headers, $params);

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
     * @param string $code
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function validateCoupon($playerUniqueId, $code = null,$headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $transactionKey = $this->getClient()->getSecretKey();

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");


        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $params = array();

        $params['playerUniqueId'] = $playerUniqueId;

        if($code)
            $params['code'] = $code;


        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $params['transactionTime'] = $UTC_DateNow;

        // NOTE: transactionTime not included in the Hash ($yyMMddHHmmss)

        $body = $playerUniqueId.":"."".":"."".":".$transactionKey;
        $bodyHashed = \sha1($body);

        $params['hash'] = $bodyHashed;

        $response = $this->request('post', '/integrations/coupon/validate', $headers, $params);


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
