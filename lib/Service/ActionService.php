<?php

namespace Gameball\Service;


class ActionService extends \Gameball\Service\AbstractService
{

    /**
     * @param ActionRequest $actionRequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function sendAction($actionRequest, $headers = null)
    {
          if($headers)
              \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
          else
              $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');


          if(!$actionRequest)
              throw new \Gameball\Exception\GameballException("ActionRequest object must be provided");

          $actionRequest->validate();

          $params = \Gameball\Util\ExtractingParameters::fromActionRequest($actionRequest);

          if(isset($params['pointsTransaction']))
          {
              $transactionKey = $this->getClient()->getTransactionKey();

              if(!$transactionKey)
                  throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

              $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
              $params['pointsTransaction']['transactionTime'] = $UTC_DateNow;

              $playerUniqueId = $params['playerUniqueId'];
              $yyMMddHHmmss = \Gameball\Util\Util::extractDateInfo($UTC_DateNow);
              $amount = isset($params['pointsTransaction']['rewardAmount'])?$params['pointsTransaction']['rewardAmount']:'';


              $body = $playerUniqueId.":".$yyMMddHHmmss.":".$amount.":".$transactionKey;
              $bodyHashed = \sha1($body);
              $params['pointsTransaction']['hash'] = $bodyHashed;
          }

          $response = $this->request('post', '/integrations/action', $headers, $params);

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
