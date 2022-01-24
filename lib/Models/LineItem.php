<?php


namespace Gameball\Models;

/**
* An instance of this class holds the information of a line item associated to a specific order request
*/

class LineItem extends AbstractModel
{

    /**
    * @var string $productId
    */
    public $productId;

    /**
    * @var string $sku
    */
    public $sku;
 
    /**
    * @var string $title
    */
    public $title;

    /**
    * @var array $category
    */
    public $category;
        
    /**
    * @var array $collection
    */
    public $collection;
    
    /**
    * @var array $tags
    */
    public $tags;
 
    /**
    * @var float $weight
    */
    public $weight;
   
    /**
    * @var string $vendor
    */
    public $vendor;
   
    /**
    * @var int $quantity
    */
    public $quantity;


    public function __construct(
        $productId = null,
        $title = null,
        $tags = null,
        $category = null,
        $weight = null,
        $sku = null,
        $quantity = null,
        $vendor = null,
        $collection = null)
    
    {
        $this->productId = $productId;
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->collection = $collection;
        $this->tags = $tags;
        $this->weight = $weight;
        $this->vendor = $vendor;
        $this->quantity = $quantity;
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
