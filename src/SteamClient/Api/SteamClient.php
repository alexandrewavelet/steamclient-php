<?php

namespace SteamClient\Api;

use SteamClient\Config\Config;
use SteamClient\Exception\ClientException;
use SteamClient\Exception\ConfigException;
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

    // HTTP methods
    const HTTP_DELETE = 'DELETE';
    const HTTP_GET    = 'GET';
    const HTTP_HEAD   = 'HEAD';
    const HTTP_PATCH  = 'PATCH';
    const HTTP_POST   = 'POST';
    const HTTP_PUT    = 'PUT';

    // Allowed HTTP methods
    private $allowedHttpMethods = [
        self::HTTP_DELETE,
        self::HTTP_GET,
        self::HTTP_HEAD,
        self::HTTP_PATCH,
        self::HTTP_POST,
        self::HTTP_PUT,
    ];

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
     * Sets the value of method
     * @param string $method the method
     * @return self
     */
    public function setMethod($method)
    {
        if (in_array($method, $this->allowedHttpMethods)) {
            $this->method = $method;
        } else {
            throw new ConfigException(
                'Invalid HTTP method : %s',
                $method
            );
        }

        return $this;
    }

    /**
     * Sets the value of endpoint
     * @param string $endpoint the endpoint
     * @return self
     */
    public function setEndpoint($endpoint)
    {
        if (strpos($endpoint, '/') !== 0) {
            $endpoint = '/'.$endpoint;
        }
        $this->endpoint = $endpoint;

        return $this;
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
     * Performs a raw API call - can be used for non-implemented endpoints
     * @param  string $method     HTTP method
     * @param  string $endpoint   Endpoint
     * @param  array  $parameters Array of query parameters
     * @return array              Call result
     */
    public function call($method, $endpoint, $parameters)
    {
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->cleanParameters();
        $this->addParameters($parameters);

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
