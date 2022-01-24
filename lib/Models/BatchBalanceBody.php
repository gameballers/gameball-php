<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a merchant branch
*/

class BatchBalanceBody extends AbstractModel
{

    /**
    * @var array $playerUniqueIds
    */
    public $playerUniqueIds;


    public function __construct(){

    }
    public static function factory($playerUniqueIds){
        $instance = new self();
        $instance->playerUniqueIds=$playerUniqueIds;
        
        return $instance;
    }

    public function validate()
    {
        if(!$this->playerUniqueIds || count($this->playerUniqueIds) == 0)
        {
            throw new \Gameball\Exception\GameballException("Player Unique IDs Array should be provided");
        }
    }

}
