<?php

namespace Gameball\Models;

/**
 * An instance of this class represents an object that collects parameters sent for Redeem Points Service API
 */
class OrderRequest extends AbstractModel
{

    public $playerUniqueId; // Required
    public $orderId; // Required
    public $orderDate; // Required
    public $totalPrice; // Required
    public $totalPaid; // Required
    public $totalDiscount;
    public $totalShipping;

    /**
    * @var LineItem[] $lineItems
    */
    public $lineItems; // Required

    /**
    * @var array $discountCodes
    */
    public $discountCodes;
    public $extra;
    public $redeemedAmount;
    public $holdReference;

    /**
    * @var bool $guest
    */
    public $guest;

    /**
    * @var Merchant $merchant
    */
    public $merchant;

    public function __construct() {}

    public static function factory(
        $playerUniqueId,
        $orderId,
        $totalPaid,
        $totalPrice,
        $totalDiscount = 0,
        $totalShipping = 0,
        // $lineItems,
        $discountCodes = null,
        $extra = null,
        $redeemedAmount = null,
        $holdReference = null,
        $guest = false,
        $merchant = null,
        $source = 1,
        $email = null, $mobile = null)
    {
         
        $instance = new self();
        $instance->playerUniqueId=$playerUniqueId;
        $instance->orderId = $orderId;
        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))) . 'Z';
        $instance->orderDate = $UTC_DateNow;
        $instance->totalPaid = $totalPaid;
        $instance->totalPrice = $totalPrice;
        $instance->totalDiscount = $totalDiscount;
        $instance->totalShipping = $totalShipping;
        $instance->lineItems = array();
        $instance->discountCodes = $discountCodes;
        $instance->extra = $extra;
        $instance->redeemedAmount = $redeemedAmount;
        $instance->holdReference = $holdReference;
        $instance->guest = $guest;
        $instance->merchant = $merchant;
        $instance->source = $source;
        // Channel Merging
        $instance->email=$email;
        $instance->mobile=$mobile;

        return $instance;
    }


    public function validate()
    {

        if (!$this->playerUniqueId) {
            throw new \Gameball\Exception\GameballException("Player Unique ID must be provided.");
        }

        if (!$this->totalPrice && !$this->totalPaid) {
            throw new \Gameball\Exception\GameballException("Total Price and Total Paid must be provided.");
        }

        if (!$this->orderId) {
            throw new \Gameball\Exception\GameballException("Order ID must be provided.");
        }

        if($this->merchant)
        {
            $this->merchant->validate();
        }

    }

    public function addLineItem($lineItem) {
        array_push($this->lineItems, 
            [
                "productId" => $lineItem->productId,
                "sku" => $lineItem->sku,
                "title" => $lineItem->title,
                "category" => $lineItem->category,
                "collection" => $lineItem->collection,
                "tags" => $lineItem->tags,
                "weight" => $lineItem->weight,
                "vendor" => $lineItem->vendor,
                "quantity" => $lineItem->quantity
            ]
        );
    }
}
