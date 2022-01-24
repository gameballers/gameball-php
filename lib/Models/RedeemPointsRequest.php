<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Redeem Points Service API
*/
class RedeemPointsRequest extends AbstractModel
{

    public $playerUniqueId;

    public $email;
  
    public $mobile;

    public $holdReference;

    public $transactionId;

    public $redeemedAmount;

    public $transactionTime = null;

    public function __construct(){

    }
    public static function factory($playerUniqueId, $holdReference, $transactionId, $redeemedAmount, $email = null, $mobile = null){
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->email = $email;
        $instance->mobile = $mobile;
        $instance->holdReference = $holdReference;
        $instance->transactionId = $transactionId;
        $instance->redeemedAmount = $redeemedAmount;
        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $instance->transactionTime = $UTC_DateNow;

        return $instance;
    }

    public function validate()
    {

        if (!$this->playerUniqueId)
        {
              throw new \Gameball\Exception\GameballException("Player Unique ID must be provided.");
        }

        if (!$this->holdReference && !$this->redeemedAmount)
        {
              throw new \Gameball\Exception\GameballException("Either Hold Reference or Redeemed Amount must be provided.");
        }

        if (!$this->transactionId)
        {
              throw new \Gameball\Exception\GameballException("Transaction ID must be provided.");
        }


    }




}
