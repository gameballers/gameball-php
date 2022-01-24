<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a merchant associated to a specific rewarding transaction
*/

class CashbackRequest extends AbstractModel
{

    /**
    * @var string $playerUniqueId
    */
    public $playerUniqueId;

    /**
    * @var string $amount
    */
    public $amount;

    /**
    * @var string $mobile
    */
    public $mobile;

    /**
    * @var string $email
    */
    public $email;

    /**
    * @var string $transactionId
    */
    public $transactionId;

     /**
    * @var DateTime|string $transactionTime
    */
    public $transactionTime;

     /**
    * @var Merchant $merchant
    */
    public $merchant;



    public function __construct(){

    }
    public static function factory($playerUniqueId, $amount, $transactionId, $merchant=null,$email = null, $mobile = null)
    {
         
        $instance = new self();
        $instance->playerUniqueId=$playerUniqueId;
        $instance->amount=$amount;
        $instance->transactionId=$transactionId;
        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))) . 'Z';
        $instance->transactionTime=$UTC_DateNow;
        $instance->merchant=$merchant;
        $instance->email=$email;
        $instance->mobile=$mobile;

        return $instance;
    }


    public function validate()
    {

        if(!$this->playerUniqueId && !$this->playerUniqueId)
        {
            throw new \Gameball\Exception\GameballException("Player Unique Id should be provided");
        }

        if(!$this->amount && !$this->amount)
        {
            throw new \Gameball\Exception\GameballException("Amount should be provided");
        }

        if(!$this->transactionId && !$this->transactionId)
        {
            throw new \Gameball\Exception\GameballException("TransactionId should be provided");
        }

        if($this->merchant)
        {
            $this->merchant->validate();
        }
    }

}
