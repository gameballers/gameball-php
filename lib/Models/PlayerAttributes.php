<?php


namespace Gameball\Models;

/**
* An instance of this class represents objects of different player attributes
*/

class PlayerAttributes extends AbstractModel
{


    /**
    * @var string $displayName
    */
    public $displayName;

    /**
    * @var string $firstName
    */
    public $firstName;

    /**
    * @var string $lastName
    */
    public $lastName;

    /**
    * @var string $email
    */
    public $email;

    /**
    * @var string $gender
    */
    public $gender;

    /**
    * @var string $mobileNumber
    */
    public $mobileNumber;

    /**
    * @var string $community
    */
    public $community;

    /**
    * @var DateTime $dateOfBirth
    */
    public $dateOfBirth;

    /**
    * @var DateTime $joinDate
    */
    public $joinDate;

    /**
    * @var array $custom (Key, Value) for custom attributes
    */
    public $custom;


    public function __construct(){

    }
    public static function factory($displayName=null,
                                $firstName=null,
                                $lastName=null,
                                $email=null,
                                $gender=null,
                                $mobileNumber=null,
                                $community=null,
                                $dateOfBirth=null,
                                $joinDate=null)
    {
        $instance = new self();
        $instance->displayName=$displayName;
        $instance->firstName=$firstName;
        $instance->lastName=$lastName;
        $instance->email=$email;
        $instance->gender=$gender;
        $instance->mobileNumber=$mobileNumber;
        $instance->community=$community;

        $instance->dateOfBirth=$dateOfBirth;
        $instance->joinDate=$joinDate;

        return $instance;
    }


    public function addCustomAttribute(string $key , $value)
    {
        if (!$this->custom)
            $this->custom = array();

        if(isset($this->custom[$key]))
        {
            throw new \Gameball\Exception\GameballException("Custom attribute already exists. ({$key})");
        }
        else
        {
            $this->custom[$key] = $value;
        }
    }

    /**
    *
    * @return bool True if the attribute exsits and removed, false otherwise
    */
    public function removeCustomAttribute(string $key)
    {
        if (!$this->custom)
            return false;
        if (!isset($this->custom[$key]))
        {
            return false;
        }
        else
        {
            unset($this->custom[$key]);
            return true;
        }
    }



    public function validate()
    {

        if(is_string($this->dateOfBirth))
        {
            $this->dateOfBirth = \strtotime($this->dateOfBirth);
        }

        if(is_string($this->joinDate))
        {
            $this->joinDate = \strtotime($this->joinDate);
        }


        $UTC_DateNow_String = \date(sprintf('Y-m-d\TH:i:s%s', substr(microtime(), 1, 4))).'Z';
        $UTC_DateNow = \strtotime($UTC_DateNow_String);
        if ($this->dateOfBirth > $UTC_DateNow)
        {
            throw new \Gameball\Exception\GameballException("Birth Date cannot be a future date. (".\date("d-m-Y",$this->dateOfBirth).")");
        }

        if ($this->joinDate > $UTC_DateNow)
        {
            throw new \Gameball\Exception\GameballException("Join Date cannot be a future date. (".\date("d-m-Y",$this->joinDate).")");
        }
    }

}
