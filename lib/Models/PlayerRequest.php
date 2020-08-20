<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Player Service API
*/
class PlayerRequest extends AbstractModel
{


    public $playerUniqueId;

    /**
    * @var PlayerAttributes $playerAttributes
    */
    public $playerAttributes;


    public function __construct(){

    }
    public static function factory($playerUniqueId, $playerAttributes = null){
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId;
        $instance->playerAttributes = $playerAttributes;

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
