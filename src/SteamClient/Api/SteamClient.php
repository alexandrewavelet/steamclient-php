<?php

namespace SteamClient\Api;

use SteamClient\Config\Config;
use SteamClient\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Query;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;

class SteamClient
{

    /** @var string Steam API key */
    private $apiKey;

    /** @var string HTTP method */
    protected $method;

    /** @var string Endpoint to reach */
    protected $endpoint;

    /** @var array Parameters for the request */
    protected $parameters;

    /** @var string Return format from the API */
    protected $responseType;

    /** @var Client HTTP client */
    private $client;

    function __construct(Config $config)
    {
        $this->apiKey = $config->getApiKey();
        $this->parameters = array();
        $this->client = new Client([
            'base_url' => $config->getSteamApiUrl(),
        ]);
        $this->responseType = $config->getResponseType();
    }

    /**
     * Adds a parameter to the request
     * @param string $name  Parameter name
     * @param string $value Parameter value
     * @return self
     */
    public function addParameter($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Adds multiple parameters - new ones will override the existing ones in case of conflict
     * @param array $parameters Parameters : parameterName => parameterValue
     * @return self
     */
    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    /**
     * Remove all parameters from the request
     * @return self
     */
    public function cleanParameters()
    {
        unset($this->parameters);
        $this->parameters = array();

        return $this;
    }

    /**
     * Gets the value of parameters
     * @return array Parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns the list of available endpoints : Will returns endpoints for the given API key, else returns public endpoints
     * @param  boolean $includeApiKey Include the API key
     * @return array                  Array of endpoints
     */
    public function getSupportedAPIList($includeApiKey = true)
    {
        $this->method = 'GET';
        $this->endpoint = '/ISteamWebAPIUtil/GetSupportedAPIList/v0001/';
        if ($includeApiKey) {
            $this->addParameter('key', $this->apiKey);
        }
        return $this->request();
    }

    /**
     * Performs an API call
     * @return array Response
     */
    protected function request()
    {
        $this->addParameter('format', 'json');
        $query = new Query($this->parameters);

        try {
            $request = $this->client->createRequest(
                $this->method,
                $this->endpoint
            );
            $request->setHeader('Accept', 'application/json');
            $request->setQuery($query);

            $response = $this->client->send($request);

            return $response->json();
        } catch (GuzzleClientException $e) {
            throw new ClientException(
                $e->getMessage()
            );
        }
    }
}
