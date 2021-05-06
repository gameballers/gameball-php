<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a merchant associated to a specific rewarding transaction
*/

class Merchant extends AbstractModel
{

    /**
    * @var string $uniqueId
    */
    public $uniqueId;

    /**
    * @var string $name
    */
    public $name;

    /**
    * @var Branch $branch
    */
    public $branch;


    public function __construct(){

    }
    public static function factory($uniqueId=null,$name=null,$branch=null)
    {
        $instance = new self();
        $instance->uniqueId=$uniqueId;
        $instance->name=$name;
        $instance->branch=$branch;

        return $instance;
    }


    public function validate()
    {

        if(!$this->uniqueId && !$this->branch)
        {
            throw new \Gameball\Exception\GameballException("One of merchant ID or branch should be provided");
        }

        if($this->branch)
        {
            $this->branch->validate();
        }
    }

}
