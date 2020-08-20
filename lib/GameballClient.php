<?php

namespace Gameball;



/**
 * Client used to send requests to Gameball's API.
 *
 */
class GameballClient extends BaseGameballClient
{
    /**
     * @var \Gameball\Service\CoreServiceFactory
     */
    private $coreServiceFactory; // Represents a collection of all available services

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new \Gameball\Service\CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
