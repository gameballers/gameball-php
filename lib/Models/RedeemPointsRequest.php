<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Redeem Points Service API
*/
class RedeemPointsRequest extends AbstractModel
{

    public $playerUniqueId;

    public $holdReference;

    public $transactionId;

    public function __construct(){

    }
    public static function factory($playerUniqueId, $holdReference, $transactionId){
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->holdReference = $holdReference;
        $instance->transactionId = $transactionId;

        return $instance;
    }

    public function validate()
    {

        if (!$this->playerUniqueId)
        {
              throw new \Gameball\Exception\GameballException("Player Unique ID must be provided.");
        }

        if (!$this->holdReference)
        {
              throw new \Gameball\Exception\GameballException("Hold Reference must be provided.");
        }

        if (!$this->transactionId)
        {
              throw new \Gameball\Exception\GameballException("Transaction ID must be provided.");
        }


    }




}
