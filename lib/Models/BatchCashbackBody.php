<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a merchant branch
*/

class BatchCashbackBody extends AbstractModel
{

    /**
    * @var array $cashbackObjects
    */
    public $cashbackObjects;


    public function __construct(){

    }
    public static function factory($cashbackObjects){
        $instance = new self();
        $instance->cashbackObjects=$cashbackObjects;
        
        return $instance;
    }

    public function validate()
    {
        if(!$this->cashbackObjects || count($this->cashbackObjects) == 0)
        {
            throw new \Gameball\Exception\GameballException("Player Unique IDs Array should be provided");
        }
    }

     /**
    * Adding Cashback Body to the request body
    * @param CashbackRequest $cashbackBody
    *
    * @throws GameballException
    */
    public function addCashbackBody($cashbackBody){
        if(!$this->cashbackObjects)
            $this->cashbackObjects = array();

        if(!$cashbackBody instanceof \Gameball\Models\CashbackRequest || is_null($cashbackBody))
        {
            throw new \Gameball\Exception\GameballException("A Cashback Request Body should be provided");
        }
        else
        {
            $cashbackBody->validate();
            array_push($this->cashbackObjects, $cashbackBody);
        }
    }

}
