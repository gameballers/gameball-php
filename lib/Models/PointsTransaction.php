<?php


namespace Gameball\Models;

/**
* For rewarding/holding points information
*/

class PointsTransaction extends AbstractModel
{


    /**
    * @var string $transactionId
    */
    public $transactionId;
    /**
    * @var int|float|string $rewardAmount
    */
    public $rewardAmount;
    /**
    * @var Merchant $merchant
    */
    public $merchant;
    /**
    * @var string $holdReference
    */
    public $holdReference;


    public function __construct(){

    }
    public static function factory($transactionId, $rewardAmount=null, $merchant=null, $holdReference =null){
        $instance = new self();
        $instance->transactionId = $transactionId;
        $instance->rewardAmount = $rewardAmount;
        $instance->merchant = $merchant;
        $instance->holdReference = $holdReference;


        return $instance;
    }

    /**
    * checking that this object is valid
    */
    public function validate()
    {

        if (!$this->transactionId)
        {
            throw new \Gameball\Exception\GameballException("Transaction ID must be provided.");
        }


        if($this->rewardAmount && !is_numeric($this->rewardAmount))
        {
            throw new \Gameball\Exception\GameballException("rewardAmount should be string of numeric value");
        }

        if($this->merchant)
        {
            $this->merchant->validate();
        }
    }
}
