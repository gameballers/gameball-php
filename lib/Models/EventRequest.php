<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Event Service API
*/
class EventRequest extends AbstractModel
{

    public $playerUniqueId;

    public $email;
    
    public $mobile;

    /**
    * @var Events $events (Key,Value) pairs
    */
    public $events;

    public function __construct(){

    }
    public static function factory($playerUniqueId, $mobile = null, $email = null){
        $instance = new self();
        $instance->playerUniqueId = $playerUniqueId; 
        $instance->events = new \Gameball\Models\Events();
        $instance->mobile = $mobile;
        $instance->email = $email;

        return $instance;
    }

    public function addEvent($eventName) {
        $this->events->addEvent($eventName);
    }

    public function addMetaData($eventName, $key, $value) {
        $this->events->addMetaData($eventName, $key, $value);
    }

    public function removeMetaData(string $eventName, string $key)
    {
        $this->events->removeMetaData($eventName, $key);
    }

    public function validate()
    {
        if (!$this->playerUniqueId)
        {
              throw new \Gameball\Exception\GameballException("Player UniqueID should be provided.");
        }

        $this->events->validate();

    }


}
