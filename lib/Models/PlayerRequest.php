<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Player Service API
*/
class PlayerRequest extends AbstractModel
{


    public $playerUniqueId;

    public $mobile;

    public $email;

    /**
    * @var PlayerAttributes $playerAttributes
    */
    public $playerAttributes;

    // Referrer's Code for referring a new player
    public $referrerCode;
    public $levelOrder;


    public function __construct(){

    }
    
    public static function factory($playerUniqueId, $mobile= null, $email = null, $playerAttributes = null, $referrerCode = null, $levelOrder = null){
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->mobile = $mobile;
        $instance->email = $email;
        $instance->playerAttributes = $playerAttributes;
        $instance->referrerCode = $referrerCode;
        $instance->levelOrder = $levelOrder;

        return $instance;
    }

    public function validate()
    {
        if (!$this->playerUniqueId)
        {
              throw new \Gameball\Exception\GameballException("Player Unique ID must be provided.");
        }

        if ($this->playerAttributes)
        {
            $this->playerAttributes->validate();
        }

    }

}
