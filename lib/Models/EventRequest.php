<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects parameters sent for Event Service API
*/
class EventRequest extends AbstractModel
{

    /**
    * @var PlayerRequest
    */
    public $playerRequest;

    /**
    * @var array $events (Key,Value) pairs
    */
    public $events;

    public function __construct(){

    }
    public static function factory($playerRequest){
        $instance = new self();
        $instance->playerRequest = $playerRequest;

        return $instance;
    }

    public function validate()
    {
        if (!$this->playerRequest)
        {
              throw new \Gameball\Exception\GameballException("Player Request object should be provided.");
        }

        $this->playerRequest->validate();



        if (!$this->events || sizeof($this->events)===0 )
        {
              throw new \Gameball\Exception\GameballException("Should specify the events to be tracked for the player");
        }


    }


    /**
    * Adding an event to the events array with no Metadata intially
    * @param string $eventName
    *
    * @throws GameballException
    */
    public function addEvent(string $eventName){
        if(!$this->events)
            $this->events = array();

        if( isset($this->events[$eventName]) )
        {
            throw new \Gameball\Exception\GameballException("The event to be added already exists");
        }
        else
        {
            $this->events[$eventName] = array();
        }
    }


    /**
    * Removing an event from the events array with all of its Metadata
    * @param string $eventName
    *
    * @return bool  True if the event exists and removed,  false otherwise
    */
    public function removeEvent(string $eventName){
        if(!$this->events)
            return false;

        if(!isset($this->events[$eventName]) )
        {
            return false;
        }
        else
        {
            unset($this->events[$eventName]);
            return true;
        }
    }


    /**
    * Adding a piece of Metadata to a specfic event
    *
    * @param string $eventName
    * @param string $key
    * @param object $value
    *
    * @throws GameballException
    *
    */
    public function addMetaData(string $eventName, string $key , $value)
    {
        if(!$this->events || !isset($this->events[$eventName]))
        {
            throw new \Gameball\Exception\GameballException("The specified event name does not exist");
        }
        else
        {
            $this->events[$eventName][$key] = $value;
        }
    }

    /**
    * @return bool  True if the this piece of Metadata exists and removed,  false otherwise
    */
    public function removeMetaData(string $eventName, string $key)
    {
        if(!$this->events || !isset($this->events[$eventName]))
        {
            return false;
        }
        else
        {
            if(!isset($this->events[$eventName][$key]))
            {
                return false;
            }
            else
            {
                unset($this->events[$eventName][$key]);
                return true;
            }
        }
    }
}
