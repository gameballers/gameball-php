<?php

namespace Gameball\Service;


class PlayerService extends \Gameball\Service\AbstractService
{

    /**
     * @param PlayerRequest $playerRequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function initializePlayer($playerRequest, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if(!$playerRequest)
            throw new \Gameball\Exception\GameballException("Must provide player request object");

        $playerRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromPlayerRequest($playerRequest);


        $response = $this->request('post', '/integrations/player', $headers, $params);

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
     * @param string $lang, the language specified by the user to be sent in headers
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballrException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getPlayerInfo($playerUniqueId ,$lang = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if($lang)
            \array_push($headers , 'lang: '.$lang);

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

          $response = $this->request('post', '/integrations/Player/Info', $headers, $params);

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
