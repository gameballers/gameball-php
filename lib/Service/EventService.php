<?php

namespace Gameball\Service;


class EventService extends \Gameball\Service\AbstractService
{

    /**
     * @param EventRequest $eventRequest
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function sendEvent($eventRequest ,$headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if(!$eventRequest)
            throw new \Gameball\Exception\GameballException("Must provide event request object");

        $eventRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromEventRequest($eventRequest);

        $response =  $this->request('post', '/integrations/event', $headers, $params);

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
