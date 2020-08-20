<?php

namespace Gameball\Service;


/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    /**
     * @var \Gameball\GameballClientInterface
     */
    protected $client;

    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param \Gameball\GameballClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Gameball\GameballClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    protected function request($method, $path, $headers, $params)
    {
        return $this->getClient()->request($method, $path, $headers, $params);
    }

}
