<?php

use SteamClient\Utils;
use SteamClient\Api\SteamAPIWrapper;
use SteamClient\Api\SteamClient;
use SteamClient\Config\Config;

require __DIR__.'/vendor/autoload.php';

$steamConfig = new Config('steamapikey');

$steamAPIWrapper = new SteamApiWrapper($steamConfig);
$availableEndpoints = $steamAPIWrapper->getSupportedAPIList();

Utils::recursiveDump($availableEndpoints);

$steamClient = new SteamClient($steamConfig);
$response = $steamClient->call(
    SteamClient::HTTP_GET,
    'ISteamNews/GetNewsForApp/v2/',
    [
        'appid' => 440,
        'count' => 5,
        'maxlength' => 300,
    ]
);

Utils::recursiveDump($response);