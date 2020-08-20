<?php

namespace Gameball\Service;


class ReferralService extends \Gameball\Service\AbstractService
{

    /**
     * @param string $playerCode
     * @param PlayerRequest $playerRequest
     *
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function createReferral($playerCode , $playerRequest , $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');


        if(!$playerCode || !$playerRequest)
            throw new \Gameball\Exception\GameballException("Must provide player refferal code and player request object");

        $playerRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromPlayerRequest($playerRequest);

        $params['playerCode'] = $playerCode;

        $response = $this->request('post', '/integrations/referral', $headers, $params);

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
