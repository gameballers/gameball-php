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

          $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
          $params['actionDate'] = $UTC_DateNow;

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
