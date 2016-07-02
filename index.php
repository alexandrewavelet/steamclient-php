<?php

use SteamClient\Utils;
use SteamClient\Api\SteamAPIHandler;
use SteamClient\Config\Config;

require __DIR__.'/vendor/autoload.php';

$steamConfig = new Config('steamapikey');
$steamAPIHandler = new SteamApiHandler($steamConfig);
$availableEndpoints = $steamAPIHandler->getSupportedAPIList();

Utils::recursiveDump($availableEndpoints);
