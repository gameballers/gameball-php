<?php

namespace Gameball\Models;


/**
* An instance of this class represents an object which collects the parameters sent for Action Service API
*/

class ActionRequest extends AbstractModel
{

    /**
    * @var PlayerRequest $playerRequest for playerUniqueId and playerAttributes
    */
    public $playerRequest;

    /**
    * @var EventRequest $eventRequest for tracked events
    */
    public $eventRequest;

    /**
    * @var PointsTransaction for rewarding/holding points information
    */
    public $pointsTransaction;

    public function __construct(){

    }
    public static function factory($playerRequest, $eventRequest=null , $pointsTransaction=null){
        $instance = new self();
        $instance->playerRequest = $playerRequest;
        $instance->eventRequest = $eventRequest;
        $instance->pointsTransaction = $pointsTransaction;

        return $instance;
    }

    /**
    * Checking that this object is a valid one
    */
    public function validate()
    {
        if(!$this->playerRequest)
        {
           throw new \Gameball\Exception\GameballException("PlayerRequest object must be provided");
        }

        $this->playerRequest->validate();

        if($this->eventRequest)
        {
           $this->eventRequest->validate();

           $id1 = $this->playerRequest->playerUniqueId;
           $id2 = $this->eventRequest->playerRequest->playerUniqueId;
           if($id1 !== $id2)
           {
              throw new \Gameball\Exception\GameballException("player ID in eventRequest should match player ID in playerRequest");
           }
        }

        if($this->pointsTransaction)
        {
          $this->pointsTransaction->validate();
        }

    }

}
