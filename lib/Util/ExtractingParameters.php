<?php

namespace Gameball\Util;

/**
* This class contains the methods required to extract parameters from different request models to be sent for the API service
*/

abstract class ExtractingParameters{

  public static function fromPlayerRequest($playerRequest){
        $params = array();


        $params['playerUniqueId'] = $playerRequest->playerUniqueId;


        if(isset($playerRequest->playerAttributes))
        {
            $params['playerAttributes']=array();

            $displayName = $playerRequest->playerAttributes->displayName;
            if(isset($displayName))
                $params['playerAttributes']['displayName'] = $displayName;

            $firstName = $playerRequest->playerAttributes->firstName;
            if(isset($firstName))
                $params['playerAttributes']['firstName'] = $firstName;

            $lastName = $playerRequest->playerAttributes->lastName;
            if(isset($lastName))
                $params['playerAttributes']['lastName'] = $lastName;

            $email = $playerRequest->playerAttributes->email;
            if(isset($email))
                $params['playerAttributes']['email'] = $email;

            $gender = $playerRequest->playerAttributes->gender;
            if(isset($gender))
                $params['playerAttributes']['gender'] = $gender;

            $mobileNumber = $playerRequest->playerAttributes->mobileNumber;
            if(isset($mobileNumber))
                $params['playerAttributes']['mobileNumber'] = $mobileNumber;

            $dateOfBirth = $playerRequest->playerAttributes->dateOfBirth;
            if(isset($dateOfBirth))
            {
                $dateOfBirth_String = \date('Y-m-d\TH:i:s' , $dateOfBirth).'Z';
                $params['playerAttributes']['dateOfBirth'] = $dateOfBirth_String;
            }

            $joinDate = $playerRequest->playerAttributes->joinDate;
            if(isset($joinDate))
            {
                $joinDate_String = \date('Y-m-d\TH:i:s' , $joinDate).'Z';
                $params['playerAttributes']['joinDate'] = $joinDate_String;
            }

            $custom = $playerRequest->playerAttributes->custom;
            if(isset($custom))
                $params['playerAttributes']['custom'] = $custom;


        }

        return $params;

    }

    public static function fromEventRequest($eventRequest)
    {
        $params = array();


        $params = ExtractingParameters::fromPlayerRequest($eventRequest->playerRequest);

        $params['events'] = $eventRequest->events;

        return $params;
    }

    public static function fromRedeemPointsRequest($redeemPointsRequest)
    {
        $params = array();

        $params['playerUniqueId'] = $redeemPointsRequest->playerUniqueId;
        $params['holdReference'] = $redeemPointsRequest->holdReference;
        $params['transactionId'] = $redeemPointsRequest->transactionId;

        return $params;
    }

    public static function fromActionRequest($actionRequest){
        $params = array();

        $params = ExtractingParameters::fromPlayerRequest($actionRequest->playerRequest);

        if($actionRequest->eventRequest)
           $params['events'] =  $actionRequest->eventRequest->events;

        if($actionRequest->pointsTransaction)
        {
            $params['pointsTransaction'] = array();

            $rewardAmount = $actionRequest->pointsTransaction->rewardAmount;
            if(isset($rewardAmount))
                $params['pointsTransaction']['rewardAmount'] = $rewardAmount;

            $holdReference = $actionRequest->pointsTransaction->holdReference;
            if(isset($holdReference))
                $params['pointsTransaction']['holdReference'] = $holdReference;

            $params['pointsTransaction']['transactionId'] = $actionRequest->pointsTransaction->transactionId;
        }

        return $params;
    }


    public static function fromCreateCouponRequest($createCouponRequest){
          $params = array();


          $params['playerUniqueId'] = $createCouponRequest->playerUniqueId;


          $startAt = $createCouponRequest->startAt;
          if(isset($startAt))
              $params['startAt'] = $startAt;

          $endsAt = $createCouponRequest->endsAt;
          if(isset($endsAt))
              $params['endsAt'] = $endsAt;

          $entitledCollectionIds = $createCouponRequest->entitledCollectionIds;
          if(isset($entitledCollectionIds))
              $params['entitledCollectionIds'] = $entitledCollectionIds;

          $entitledProductIds = $createCouponRequest->entitledProductIds;
          if(isset($entitledProductIds))
              $params['entitledProductIds'] = $entitledProductIds;

          $oncePerCustomer = $createCouponRequest->oncePerCustomer;
          if(isset($oncePerCustomer))
              $params['oncePerCustomer'] = $oncePerCustomer;

          $prerequisiteQuantityRange = $createCouponRequest->prerequisiteQuantityRange;
          if(isset($prerequisiteQuantityRange))
              $params['prerequisiteQuantityRange'] = $prerequisiteQuantityRange;

          $prerequisiteShippingPriceRange = $createCouponRequest->prerequisiteShippingPriceRange;
          if(isset($prerequisiteShippingPriceRange))
              $params['prerequisiteShippingPriceRange'] = $prerequisiteShippingPriceRange;

          $prerequisiteSubtotalRange = $createCouponRequest->prerequisiteSubtotalRange;
          if(isset($prerequisiteSubtotalRange))
              $params['prerequisiteSubtotalRange'] = $prerequisiteSubtotalRange;

          $prerequisiteCollectionIds = $createCouponRequest->prerequisiteCollectionIds;
          if(isset($prerequisiteCollectionIds))
              $params['prerequisiteCollectionIds'] = $prerequisiteCollectionIds;

          $prerequisiteProductIds = $createCouponRequest->prerequisiteProductIds;
          if(isset($prerequisiteProductIds))
              $params['prerequisiteProductIds'] = $prerequisiteProductIds;

          $code = $createCouponRequest->code;
          if(isset($code))
          $params['code'] = $code;

          $usageLimit = $createCouponRequest->usageLimit;
          if(isset($usageLimit))
              $params['usageLimit'] = $usageLimit;

          $value = $createCouponRequest->value;
          if(isset($value))
              $params['value'] = $value;

          $valueType = $createCouponRequest->valueType;
          if(isset($valueType))
              $params['valueType'] = $valueType;

          $cap = $createCouponRequest->cap;
          if(isset($cap))
              $params['cap'] = $cap;


          return $params;

      }

}
