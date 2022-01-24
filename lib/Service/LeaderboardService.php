<?php

namespace Gameball\Service;


class LeaderboardService extends \Gameball\Service\AbstractService
{

    /**
     * @param DateTime|string $from optional from date
     * @param DateTime|string $to optional to date
     * @param string $playerUniqueId
     * @param string $challengeId Challenge ID
     * @param string $playerTag Player Tag
     * @param string $challengeTag Challenge Tag
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getLeaderboard($from = null, $to = null, $limit = 20,
        $playerUniqueId = null, $challengeId = null, $playerTag = null, $challengeTag = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        $params = array(
            'from' => $from,
            'to' => $to,
            'limit' => $limit,
            'playerUniqueId' => $playerUniqueId,
            'challengeId' => $challengeId,
            'playerTag' => $playerTag,
            'challengeTag' => $challengeTag
        );

        $response =  $this->request('get', '/integrations/leaderboard', $headers, $params);

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
