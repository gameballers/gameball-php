<?php

namespace Gameball\Models;


/**
 * An instance of this class represents an object which collects the parameters sent for Action Service API
 * CURRENTLY DEPRECATED
 */

class ActionRequest extends AbstractModel
{

    public $playerUniqueId;

    public $mobile;

    public $email;
    /**
    * @var Events $events (Key,Value) pairs
    */
    public $events;

    public $actionId;

    public $rewardAmount;

    public $holdReference;

    public $redeemedAmount;

    public function __construct()
    {
    }
    
    public static function factory($playerUniqueId, $actionId, $mobile = null, $email = null, $rewardAmount = null, $holdReference = null)
    {
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->mobile = $mobile;
        $instance->email = $email;
        $instance->actionId = $actionId;
        $instance->rewardAmount = $rewardAmount;
        $instance->holdReference = $holdReference;

        return $instance;
    }

    /**
     * Checking that this object is a valid one
     */
    public function validate()
    {
        if(!$this->playerUniqueId && !$this->playerUniqueId)
        {
            throw new \Gameball\Exception\GameballException("Player Unique Id should be provided");
        }

        if (!$this->actionId) {
            throw new \Gameball\Exception\GameballException("Action ID must be provided");
        }

        if ($this->rewardAmount && !is_numeric($this->rewardAmount)) {
            throw new \Gameball\Exception\GameballException("rewardAmount should be string of numeric value");
        }

        $this->events->validate();
    }

}
