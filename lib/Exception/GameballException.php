<?php


namespace Gameball\Exception;

/**
* GameballException is the exception thrown for any wrong behaviour while communicating with the APIs
* and is customized by passing descriptive messages when throwing it
*/

class GameballException extends \Exception implements ExceptionInterface
{

    /**
    * @var int $httpStatusCode
    */
    private $httpStatusCode;

    /**
    * @var int $gameballCode
    */
    private $gameballCode; // Gameball internal error code


    /**
     * Creates a new error exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatusCode
     * @param null|int $gameballCode
     * @return static
     */
    public static function factory($message, $httpStatusCode=null , $gameballCode=null) {

        if($message===null)
            $message ="UNDEFINED ERROR";

        $message .= ($httpStatusCode===null)?'':"\nThe http code is: {$httpStatusCode}";
        $message .= ($gameballCode===null)?'':"\nThe Gameball internal code is: {$gameballCode}";

        $instance = new static($message);

        $instance->setHttpStatusCode($httpStatusCode);
        $instance->setGameballCode($gameballCode);

        return $instance;
    }



    /**
         * Gets the HTTP status code.
         *
         * @return null|int
         */
        public function getHttpStatusCode()
        {
            return $this->httpStatusCode;
        }

        /**
         * Sets the HTTP status code.
         *
         * @param null|int $httpStatusCode
         */
        public function setHttpStatusCode($httpStatusCode)
        {
            $this->httpStatusCode = $httpStatusCode;
        }

        /**
         * Gets Gameball error code.
         *
         *
         * @return null|int
         */
         public function getGameballCode()
         {
             return $this->gameballCode;
         }

        /**
         * Sets the Gameball error code.
         *
         * @param null|int $gameballCode
         */
        public function setGameballCode($gameballCode)
        {
            $this->gameballCode = $gameballCode;
        }

        /**
         * Returns the string representation of the exception.
         *
         * @return string
         */
        public function __toString()
        {
            $statusStr = (null === $this->getHttpStatusCode()) ? '' : "(Status {$this->getHttpStatusCode()}) ";

            return "{$statusStr}{$this->getMessage()}";
        }


}
