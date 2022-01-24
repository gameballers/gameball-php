<?php

namespace Gameball\Util;

/**
 * This class contains the methods required to extract parameters from different request models to be sent for the API service
 */

abstract class ExtractingParameters
{

    public static function fromPlayerRequest($playerRequest)
    {
        $params = array();

        $params['playerUniqueId'] = $playerRequest->playerUniqueId;
        $params = self::handleChannelMerging($playerRequest, $params);

        if (isset($playerRequest->playerAttributes)) {
            $params['playerAttributes'] = array();

            $displayName = $playerRequest->playerAttributes->displayName;
            if (isset($displayName))
                $params['playerAttributes']['displayName'] = $displayName;

            $firstName = $playerRequest->playerAttributes->firstName;
            if (isset($firstName))
                $params['playerAttributes']['firstName'] = $firstName;

            $lastName = $playerRequest->playerAttributes->lastName;
            if (isset($lastName))
                $params['playerAttributes']['lastName'] = $lastName;

            $email = $playerRequest->playerAttributes->email;
            if (isset($email))
                $params['playerAttributes']['email'] = $email;

            $gender = $playerRequest->playerAttributes->gender;
            if (isset($gender))
                $params['playerAttributes']['gender'] = $gender;

            $mobile = $playerRequest->playerAttributes->mobile;
            if (isset($mobile))
                $params['playerAttributes']['mobile'] = $mobile;

            $community = $playerRequest->playerAttributes->community;
            if (isset($community))
                $params['playerAttributes']['community'] = $community;

            $tags = $playerRequest->playerAttributes->tags;
            if (isset($tags))
                $params['playerAttributes']['tags'] = $tags;

            $dateOfBirth = $playerRequest->playerAttributes->dateOfBirth;
            if (isset($dateOfBirth)) {
                $dateOfBirth_String = \date('Y-m-d\TH:i:s', $dateOfBirth) . 'Z';
                $params['playerAttributes']['dateOfBirth'] = $dateOfBirth_String;
            }

            $joinDate = $playerRequest->playerAttributes->joinDate;
            if (isset($joinDate)) {
                $joinDate_String = \date('Y-m-d\TH:i:s', $joinDate) . 'Z';
                $params['playerAttributes']['joinDate'] = $joinDate_String;
            }

            $custom = $playerRequest->playerAttributes->custom;
            if (isset($custom))
                $params['playerAttributes']['custom'] = $custom;
        }

        $params['referrerCode'] = $playerRequest->referrerCode;
        $params['levelOrder'] = $playerRequest->levelOrder;

        return $params;
    }

    public static function fromEventRequest($eventRequest)
    {
        $params = array();

        $params['events'] = $eventRequest->events->events;
        $params['playerUniqueId'] = $eventRequest->playerUniqueId;
        $params['mobile'] = $eventRequest->mobile;
        $params['email'] = $eventRequest->email;

        return $params;
    }
    


    public static function fromBatchRequest($batchRequest)
    {
        $params = array();

        $params['method'] = $batchRequest->method;
        $params['operation'] = $batchRequest->operation;
        $params['params'] = $batchRequest->params;
        if ($batchRequest->body instanceof \Gameball\Models\BatchCashbackBody) {
            $params['body'] = $batchRequest->body->cashbackObjects;
        } elseif ($batchRequest->body instanceof \Gameball\Models\BatchRedeemBody) {
            $params['body'] = $batchRequest->body->redeemObjects;
        } else {
            $params['body'] = $batchRequest->body;
        }

        return $params;
    }

    public static function fromOrderRequest($orderRequest)
    {
        $params = array();

        $params["playerUniqueId"] = $orderRequest->playerUniqueId;
        $params["orderId"] = $orderRequest->orderId;
        $params["orderDate"] = $orderRequest->orderDate;
        $params["totalPaid"] = $orderRequest->totalPaid;
        $params["totalPrice"] = $orderRequest->totalPrice;
        $params["totalDiscount"] = $orderRequest->totalDiscount;
        $params["totalShipping"] = $orderRequest->totalShipping;
        $params["lineItems"] = $orderRequest->lineItems;
        $params["discountCodes"] = $orderRequest->discountCodes;
        $params["extra"] = $orderRequest->extra;
        $params["redeemedAmount"] = $orderRequest->redeemedAmount;
        $params["holdReference"] = $orderRequest->holdReference;
        $params["guest"] = $orderRequest->guest;
        $params["source"] = $orderRequest->source;

        
        if ($orderRequest->merchant) {
            $merchant = $orderRequest->merchant;
            // Extracting info from the merchant object
            $params['merchant'] = array();
            $merchantId = $merchant->uniqueId;
            if (isset($merchantId)) {
                $params['merchant']['uniqueId'] = $merchantId;
            }
            $merchantName = $merchant->name;
            if (isset($merchantName)) {
                $params['merchant']['name'] = $merchantName;
            }
            $branch = $merchant->branch;
            if (isset($branch)) {
                $params['merchant']['branch'] = array();
                $params['merchant']['branch']['uniqueId'] = $branch->uniqueId;
                $branchName = $branch->name;
                if (isset($branchName)) {
                    $params['merchant']['branch']['name'] = $branchName;
                }
            }
        }

        $params = self::handleChannelMerging($orderRequest, $params);

        return $params;
    }

    public static function fromCashbackRequest($cashbackRequest)
    {
        $params = array();

        $params['playerUniqueId'] = $cashbackRequest->playerUniqueId;
        $params['amount'] = $cashbackRequest->amount;
        $params['transactionId'] = $cashbackRequest->transactionId;
        $params['transactionTime'] = $cashbackRequest->transactionTime;
        $params['merchant'] = $cashbackRequest->merchant;

        $params = self::handleChannelMerging($cashbackRequest, $params);

        if ($cashbackRequest->merchant) {
            $merchant = $cashbackRequest->merchant;
            // Extracting info from the merchant object
            $params['merchant'] = array();
            $merchantId = $merchant->uniqueId;
            if (isset($merchantId)) {
                $params['merchant']['uniqueId'] = $merchantId;
            }
            $merchantName = $merchant->name;
            if (isset($merchantName)) {
                $params['merchant']['name'] = $merchantName;
            }
            $branch = $merchant->branch;
            if (isset($branch)) {
                $params['merchant']['branch'] = array();
                $params['merchant']['branch']['uniqueId'] = $branch->uniqueId;
                $branchName = $branch->name;
                if (isset($branchName)) {
                    $params['merchant']['branch']['name'] = $branchName;
                }
            }
        }

        return $params;
    }

    public static function fromRedeemPointsRequest($redeemPointsRequest)
    {
        $params = array();

        $params['playerUniqueId'] = $redeemPointsRequest->playerUniqueId;
        $params['redeemedAmount'] = $redeemPointsRequest->redeemedAmount;
        $params['holdReference'] = $redeemPointsRequest->holdReference;
        $params['transactionId'] = $redeemPointsRequest->transactionId;
        $params['transactionTime'] = $redeemPointsRequest->transactionTime;

        $params = self::handleChannelMerging($redeemPointsRequest, $params);

        return $params;
    }

    public static function fromManualTransactionRequest($manualRequest)
    {
        $params = array();

        $params['playerUniqueId'] = $manualRequest->playerUniqueId;
        $params['amount'] = $manualRequest->amount;
        $params['points'] = $manualRequest->points;
        $params['username'] = $manualRequest->username;
        $params['reason'] = $manualRequest->reason;
        $params['transactionId'] = $manualRequest->transactionId;
        $params['transactionTime'] = $manualRequest->transactionTime;

        $params = self::handleChannelMerging($manualRequest, $params);

        return $params;
    }

    public static function fromActionRequest($actionRequest)
    {
        $params = array();

        if ($actionRequest->events) {
            $params['events'] =  $actionRequest->events->events;
        }

        $params['playerUniqueId'] =  $actionRequest->playerUniqueId;

        if (isset($actionRequest->rewardAmount))
            $params['rewardAmount'] = $actionRequest->rewardAmount;

        if (isset($actionRequest->holdReference))
            $params['holdReference'] = $actionRequest->holdReference;

        $params['actionId'] = $actionRequest->actionId;

        return $params;
    }


    public static function fromCreateCouponRequest($createCouponRequest)
    {
        $params = array();


        $params['playerUniqueId'] = $createCouponRequest->playerUniqueId;


        $startAt = $createCouponRequest->startAt;
        if (isset($startAt))
            $params['startAt'] = $startAt;

        $endsAt = $createCouponRequest->endsAt;
        if (isset($endsAt))
            $params['endsAt'] = $endsAt;

        $entitledCollectionIds = $createCouponRequest->entitledCollectionIds;
        if (isset($entitledCollectionIds))
            $params['entitledCollectionIds'] = $entitledCollectionIds;

        $entitledProductIds = $createCouponRequest->entitledProductIds;
        if (isset($entitledProductIds))
            $params['entitledProductIds'] = $entitledProductIds;

        $oncePerCustomer = $createCouponRequest->oncePerCustomer;
        if (isset($oncePerCustomer))
            $params['oncePerCustomer'] = $oncePerCustomer;

        $prerequisiteQuantityRange = $createCouponRequest->prerequisiteQuantityRange;
        if (isset($prerequisiteQuantityRange))
            $params['prerequisiteQuantityRange'] = $prerequisiteQuantityRange;

        $prerequisiteShippingPriceRange = $createCouponRequest->prerequisiteShippingPriceRange;
        if (isset($prerequisiteShippingPriceRange))
            $params['prerequisiteShippingPriceRange'] = $prerequisiteShippingPriceRange;

        $prerequisiteSubtotalRange = $createCouponRequest->prerequisiteSubtotalRange;
        if (isset($prerequisiteSubtotalRange))
            $params['prerequisiteSubtotalRange'] = $prerequisiteSubtotalRange;

        $prerequisiteCollectionIds = $createCouponRequest->prerequisiteCollectionIds;
        if (isset($prerequisiteCollectionIds))
            $params['prerequisiteCollectionIds'] = $prerequisiteCollectionIds;

        $prerequisiteProductIds = $createCouponRequest->prerequisiteProductIds;
        if (isset($prerequisiteProductIds))
            $params['prerequisiteProductIds'] = $prerequisiteProductIds;

        $code = $createCouponRequest->code;
        if (isset($code))
            $params['code'] = $code;

        $usageLimit = $createCouponRequest->usageLimit;
        if (isset($usageLimit))
            $params['usageLimit'] = $usageLimit;

        $value = $createCouponRequest->value;
        if (isset($value))
            $params['value'] = $value;

        $valueType = $createCouponRequest->valueType;
        if (isset($valueType))
            $params['valueType'] = $valueType;

        $cap = $createCouponRequest->cap;
        if (isset($cap))
            $params['cap'] = $cap;


        return $params;
    }

    public static function handleChannelMerging($request, $params)
    {

        if (isset($request->email) && !is_null($request->email)) {
            $params['email'] = $request->email;
        }

        if (isset($request->mobile) && !is_null($request->mobile)) {
            $params['mobile'] = $request->mobile;
        }

        return $params;
    }
}
