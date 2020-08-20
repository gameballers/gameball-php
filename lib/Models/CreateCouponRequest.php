<?php

namespace Gameball\Models;

/**
* An instance of this class represents an object that collects the parameters sent for Create Coupon Service API
*/
class CreateCouponRequest extends AbstractModel
{

    /**
    * @var string $playerUniqueId
    */
    public $playerUniqueId;

    /**
    * @var DateTime|string $startAt
    */
    public $startAt; //when the price rule starts.
    /**
    * @var DateTime|string $endsAt
    */
    public $endsAt; //when the price rule ends. Must be after starts_at.


    public $entitledCollectionIds;      // A list of IDs of collections whose products will be eligible to the discount. It can be used only with target_type set to line_item and target_selection set to entitled.
                                        //It can't be used in combination with entitled_product_ids or entitled_variant_ids.


    public $entitledProductIds;    //A list of IDs of products that will be entitled to the discount.
                                  //It can be used only with target_type set to line_item and target_selection set to entitled.


    public $oncePerCustomer;     //Whether the generated discount code will be valid only for a single use per customer. This is tracked using customer ID.



    public $prerequisiteQuantityRange;   //The minimum number of items for the price rule to be applicable.The quantity of an entitled cart item must be greater than or equal to this value.



    public $prerequisiteShippingPriceRange;    //The maximum shipping price for the price rule to be applicable.



    public $prerequisiteSubtotalRange;   //The minimum subtotal for the price rule to be applicable.



    public $prerequisiteCollectionIds;    //List of collection ids that will be a prerequisites for a Buy X Get Y discoun

    public $prerequisiteProductIds;   //List of product ids that will be a prerequisites for a Buy X Get Y type discount

    public $code;

    public $usageLimit;  // The maximum number of times the price rule can be used, per discount code.

    public $value;   // The value of the price rule.

    public $valueType;   //  fixed_amount: Applies a discount of value as a unit of the store's currency.

    public $cap;  //In case the voucher has capped value for % type



    public function __construct(){

    }


    // check the validation of the object
    public function validate()
    {

        if (!$this->playerUniqueId)
        {
              throw new \Gameball\Exception\GameballException("Player Unique ID Must be provided.");
        }



        // check for starting date less than end date
        //continue validation when understanding the meaning of parameters more
    }

}
