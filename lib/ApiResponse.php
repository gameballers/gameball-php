<?php

namespace Gameball;

use Gameball\Util\CaseInsensitiveArray;

/**
 * Class ApiResponse collects several response information
 */
class ApiResponse
{

    /**
    * @var string
    */
    public $body;  // Response body returned from Gameball server as a JSON format string


    /**
     * @var int
     */
    public $code;  // HTTP status code

    /**
     * @var null|array|CaseInsensitiveArray
     */
    public $headers;  //HTTP response header


    /**
     * @var null|array
     */
    public $decodedJson; // The response returned from Gameball but as an array


    /**
     * @param string $body
     * @param int $code
     * @param null|array|CaseInsensitiveArray $headers
     * @param null|array $decodedJson
     */
    public function __construct($body, $code, $headers, $decodedJson)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->decodedJson = $decodedJson;
    }

    public function isSuccess(){
      return $this->code == 200;
    }
}
