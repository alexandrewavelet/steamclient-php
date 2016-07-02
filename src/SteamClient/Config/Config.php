<?php

namespace SteamClient\Config;

use SteamClient\Exception\ConfigException;

class Config
{
    /** @var string Steam API key */
    protected $apiKey;

    /** @var string API response format */
    protected $responseType;

    /** @var string Base API URL */
    protected $steamApiUrl;

    /** Response formats */
    const FORMAT_JSON = 'json';
    const FORMAT_XML  = 'xml';
    const FORMAT_VDF  = 'vdf';

    /** @var array Available response formats */
    private $allowedResponsesType = [
        self::FORMAT_JSON,
    ];


    function __construct($apiKey, $responseType = 'json')
    {
        $this->setApiKey($apiKey);
        $this->setResponseType($responseType);
        $this->setSteamApiUrl('http://api.steampowered.com');
    }

    /**
     * Gets the value of apiKey.
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the value of apiKey.
     * @param string $apiKey the api key
     * @return self
     */
    protected function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Gets the value of responseType.
     * @return string
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * Sets the value of responseType.
     * @param string $responseType the response type
     * @return self
     */
    protected function setResponseType($responseType)
    {
        if (in_array($responseType, $this->allowedResponsesType)) {
            $this->responseType = $responseType;
        } else {
            throw new ConfigException(
                sprintf(
                    'Invalid response type : %s',
                    $responseType
                )
            );
        }

        return $this;
    }

    /**
     * Gets the value of steamApiUrl.
     * @return string
     */
    public function getSteamApiUrl()
    {
        return $this->steamApiUrl;
    }

    /**
     * Sets the value of steamApiUrl.
     * @param string $steamApiUrl the steam api url
     * @return self
     */
    protected function setSteamApiUrl($steamApiUrl)
    {
        $this->steamApiUrl = rtrim($steamApiUrl, '/');

        return $this;
    }
}
