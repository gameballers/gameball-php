<?php

namespace Gameball\Service;


class BatchService extends \Gameball\Service\AbstractService
{

    /**
     * @param BatchRequest $batchRequest
     * 
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function startBatch($batchRequest , $headers = null)
    {
        $transactionKey = $this->getClient()->getSecretKey();

        if($headers)
              \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey(),
              'secretKey: '.$this->getClient()->getSecretKey() , 'Content-Type: application/json');
        else
              $headers = array(
                  'APIKey: '.$this->getClient()->getApiKey(),
                  'secretKey: '.$this->getClient()->getSecretKey(),
                  'Content-Type: application/json'
              );

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$batchRequest)
            throw new \Gameball\Exception\GameballException("Must provide batch request object");

        $batchRequest->validate();

        $params = \Gameball\Util\ExtractingParameters::fromBatchRequest($batchRequest);

        $response =  $this->request('post', '/integrations/batch', $headers, $params);

        if($response->isSuccess())
        {
            $linesArray = array_filter(preg_split('/\R/', $response->body));
            $resulted = array();
            $resulted["batchId"] = end($linesArray);

            return json_decode(json_encode($resulted));
        }
        else
        {
          $httpStatusCode = $response->code;

          $gameballCode = isset($response->decodedJson['code'])?$response->decodedJson['code']:null;
          $message = isset($response->decodedJson['message'])?$response->decodedJson['message']:null;
          throw \Gameball\Exception\GameballException::factory($message,$httpStatusCode,$gameballCode);
        }
    }

    public function getBatch($batchId , $headers = null)
    {
        $transactionKey = $this->getClient()->getSecretKey();

        if($headers)
              \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey(),
              'secretKey: '.$this->getClient()->getSecretKey() , 'Content-Type: application/json');
        else
              $headers = array(
                  'APIKey: '.$this->getClient()->getApiKey(),
                  'secretKey: '.$this->getClient()->getSecretKey(),
                  'Content-Type: application/json'
              );

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$batchId)
            throw new \Gameball\Exception\GameballException("Must provide Batch ID");

        $response =  $this->request('get', "/integrations/batch/{$batchId}", $headers, null);

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

    public function stopBatch($batchId , $headers = null)
    {
        $transactionKey = $this->getClient()->getSecretKey();

        if($headers)
              \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey(),
              'secretKey: '.$this->getClient()->getSecretKey() , 'Content-Type: application/json');
        else
              $headers = array(
                  'APIKey: '.$this->getClient()->getApiKey(),
                  'secretKey: '.$this->getClient()->getSecretKey(),
                  'Content-Type: application/json'
              );

        if(!$transactionKey)
            throw new \Gameball\Exception\GameballException("Must have a transaction key to do the request");

        if(!$batchId)
            throw new \Gameball\Exception\GameballException("Must provide Batch ID");

        $response =  $this->request('delete', "/integrations/batch/{$batchId}", $headers, null);

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
