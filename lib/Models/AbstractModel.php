<?php

namespace Gameball\Models;

/**
* The class acts as an abstract parent for all request models
*/

abstract class AbstractModel
{

    /**
    * to validate the model before sending it
    */
    abstract public function validate();


}
