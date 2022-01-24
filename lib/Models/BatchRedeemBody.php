<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a Batch Redeem Request Bodies
*/

class BatchRedeemBody extends AbstractModel
{

    /**
    * @var array $redeemObjects
    */
    public $redeemObjects;


    public function __construct(){

    }
    public static function factory($redeemObjects){
        $instance = new self();
        $instance->redeemObjects=$redeemObjects;
        
        return $instance;
    }

    public function validate()
    {
        if(!$this->redeemObjects || count($this->redeemObjects) == 0)
        {
            throw new \Gameball\Exception\GameballException("Redeem Object Payload Array should be provided");
        }
    }

     /**
    * Adding Redeem Body to the Body Array Parameter
    * @param RedeemPointsRequest $redeemBody
    *
    * @throws GameballException
    */
    public function addRedeemBody($redeemBody){
        if(!$this->redeemObjects)
            $this->redeemObjects = array();

        if(!$redeemBody instanceof \Gameball\Models\RedeemPointsRequest || is_null($redeemBody))
        {
            throw new \Gameball\Exception\GameballException("A Redeem Request Body should be provided");
        }
        else
        {
            $redeemBody->validate();
            array_push($this->redeemObjects, $redeemBody);
        }
    }

}
