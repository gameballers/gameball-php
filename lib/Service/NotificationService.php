<?php

namespace Gameball\Service;


class NotificationService extends \Gameball\Service\AbstractService
{

    /**
     * @param null|array $headers
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function getPlayerNotifications($playerUniqueId, $isRead = null, $lang = null, $page = 1, $limit = 50, $email = null, $mobile = null, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        if(!$playerUniqueId)
            throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");    

        if (isset($isRead)) {
            if (is_bool($isRead)) {
                $isRead = ($isRead) ? "true" : "false";
            }
        }

        $params = array(
            'isRead' => $isRead,
            'lang' => $lang,
            'page' => $page,
            'limit' => $limit
        );

        if (isset($email) && !is_null($email)) {
            $params['email'] = $email;
        }
        
        if (isset($mobile) && !is_null($mobile)) {
            $params['mobile'] = $mobile;
        }

        $response =  $this->request('get', "/integrations/notifications/{$playerUniqueId}", $headers, $params);

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
     *
     * @throws \Gameball\Exception\GameballException if the request fails
     *
     * @return \Gameball\Gameball\ApiResponse
     */
    public function markPlayerNotificationsAsRead($notificationIds, $headers = null)
    {
        if($headers)
            \array_push($headers , 'APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');
        else
            $headers =array('APIKey: '.$this->getClient()->getApiKey() , 'Content-Type: application/json');

        // if(!$playerUniqueId)
        //     throw new \Gameball\Exception\GameballException("Must provide playerUniqueId");  

        if(!$notificationIds || empty($notificationIds))
            throw new \Gameball\Exception\GameballException("Must provide Notification IDs array"); 

        $params['notificationIds'] = $notificationIds;

        $response =  $this->request('put', "/integrations/notifications", $headers, $params);

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
