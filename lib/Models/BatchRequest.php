<?php

namespace Gameball\Models;

/**
 * An instance of this class represents an object that collects parameters sent for Redeem Points Service API
 */
class BatchRequest extends AbstractModel
{
    public $method; // Required
    public $operation; // Required
    public $params; // Required
    public $body; // Required

    public function __construct(
        $method,
        $operation,
        $params,
        $body
    ) {
        $this->method = strtoupper($method);
        $this->operation = strtolower($operation);
        $this->params = $params;
        $this->body = $body;
    }


    public function validate()
    {
        $possible_verbs = ["GET", "POST", "PUT"];
        $possible_operations = ["cashback", "redeem", "balance"];

        if(!$this->method)
            throw new \Gameball\Exception\GameballException("Must have a method to do the request");

        if(!$this->operation)
            throw new \Gameball\Exception\GameballException("Must have an operation to do the request");

        if (!in_array($this->method, $possible_verbs)) {
            throw new \Gameball\Exception\GameballException("The {$this->method} Method Not Supported!");
        }

        if (!in_array($this->operation, $possible_operations)) {
            throw new \Gameball\Exception\GameballException("The {$this->operation} Operation Not Supported!");
        }
    }
}
