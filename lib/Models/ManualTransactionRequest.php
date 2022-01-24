<?php


namespace Gameball\Models;

/**
 * An instance of this class holds the information of a merchant associated to a specific rewarding transaction
 */

class ManualTransactionRequest extends AbstractModel
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
     * @var string $username
     */
    public $username;

    /**
     * @var string $reason
     */
    public $reason;

    /**
     * @var string $points
     */
    public $points;



    public function __construct()
    {
    }
    public static function factory($playerUniqueId, $amount, $points, $transactionId, $reason, $username,  $email = null, $mobile = null)
    {

        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->amount = $amount;
        $instance->points = $points;
        $instance->transactionId = $transactionId;
        $UTC_DateNow = date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))) . 'Z';
        $instance->transactionTime = $UTC_DateNow;
        $instance->email = $email;
        $instance->mobile = $mobile;
        $instance->reason = $reason;
        $instance->username = $username;

        return $instance;
    }


    public function validate()
    {

        if (!$this->playerUniqueId && !$this->playerUniqueId) {
            throw new \Gameball\Exception\GameballException("Player Unique Id should be provided");
        }

        if (!$this->amount && !$this->points) {
            throw new \Gameball\Exception\GameballException("Amount or points should be provided");
        }

        if (!$this->transactionId && !$this->transactionId) {
            throw new \Gameball\Exception\GameballException("TransactionId should be provided");
        }

        if (!$this->username) {
            throw new \Gameball\Exception\GameballException("Username should be provided");
        }

    }
}
