<?php

namespace SteamClient\Api;

use SteamClient\Config\Config;

class SteamAPIWrapper
{
    /** @var SteamClient Client for Steam API */
    private $steamClient;

    function __construct(Config $config)
    {
        $this->steamClient = new SteamClient($config);
    }

    /**
     * Returns the list of available endpoints : Will returns endpoints for the given API key, else returns public endpoints
     * @param   boolean $includeApiKey  Include the API key
     * @return  array                   List of endpoints
     */
    public function getSupportedAPIList($includeApiKey = true)
    {
        $this->steamClient->cleanParameters();
        return $this->steamClient->getSupportedAPIList($includeApiKey);
    }
}
