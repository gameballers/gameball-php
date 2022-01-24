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
    public function getPlayerInfo($playerUniqueId, $mobile= null, $email = null, $lang = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if($lang)
            \array_push($headers , 'lang: '.$lang);


        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $pathParam = (isset($email)) ? $email : ((isset($mobile)) ? $mobile : $playerUniqueId);

        $response = $this->request('get', "/integrations/player/{$pathParam}", $headers, null);

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
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballrException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getPlayerBalance($playerUniqueId, $mobile= null, $email = null, $lang = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey(),
            'secretKey: '.$this->getClient()->getSecretKey() , 'Content-Type: application/json');
        else
            $headers = array(
                'APIKey: '.$this->getClient()->getApiKey(),
                'secretKey: '.$this->getClient()->getSecretKey(),
                'Content-Type: application/json'
            );

        if($lang)
            \array_push($headers , 'lang: '.$lang);

        $secretKey = $this->getClient()->getSecretKey();

        if(!$secretKey)
            throw new \Gameball\Exception\GameballException("Must have a secret key to do the request");


        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $pathParam = (isset($email)) ? $email : ((isset($mobile)) ? $mobile : $playerUniqueId);

        $response = $this->request('get', "/integrations/player/{$pathParam}/balance", $headers, null);

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
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballrException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getPlayerProgress($playerUniqueId, $mobile= null, $email = null, $lang = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey(),
            'secretKey: '.$this->getClient()->getSecretKey() , 'Content-Type: application/json');
        else
            $headers = array(
                'APIKey: '.$this->getClient()->getApiKey(),
                'secretKey: '.$this->getClient()->getSecretKey(),
                'Content-Type: application/json'
            );

        if($lang)
            \array_push($headers , 'lang: '.$lang);

        $secretKey = $this->getClient()->getSecretKey();

        if(!$secretKey)
            throw new \Gameball\Exception\GameballException("Must have a secret key to do the request");


        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");

        $pathParam = (isset($email)) ? $email : ((isset($mobile)) ? $mobile : $playerUniqueId);

        $response = $this->request('get', "/integrations/player/{$pathParam}/progress", $headers, null);

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
     * @param null|array $headers
     * @param string $tags
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function attachTags($playerUniqueId, $tags, $mobile= null, $email = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if (!isset($tags) || trim($tags) === '') {
            throw new \Gameball\Exception\GameballException("Tags Cannot Be empty");
        }

        $params = [
            "tags" => $tags
        ];

        $pathParam = (isset($email)) ? $email : ((isset($mobile)) ? $mobile : $playerUniqueId);

        $response = $this->request('post', "/integrations/player/{$pathParam}/tags", $headers, $params);

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
     * @param null|array $headers
     * @param string $tags
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function detachTags($playerUniqueId, $tags, $mobile= null, $email = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if (!isset($tags) || trim($tags) === '') {
            throw new \Gameball\Exception\GameballException("Tags cannot be empty!");
        }

        $params = [
            "tags" => $tags
        ];

        $pathParam = (isset($email)) ? $email : ((isset($mobile)) ? $mobile : $playerUniqueId);

        $response = $this->request('delete', "/integrations/player/{$pathParam}/tags", $headers, $params);

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
