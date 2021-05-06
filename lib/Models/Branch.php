<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a merchant branch
*/

class Branch extends AbstractModel
{

    /**
    * @var string $uniqueId
    */
    public $uniqueId;

    /**
    * @var string $name
    */
    public $name;


    public function __construct(){

    }
    public static function factory($uniqueId,$name=null){
        $instance = new self();
        $instance->uniqueId=$uniqueId;
        $instance->name=$name;
        
        return $instance;
    }

    public function validate()
    {
        if(!$this->uniqueId)
        {
            throw new \Gameball\Exception\GameballException("Branch ID should be provided");
        }
    }

}
