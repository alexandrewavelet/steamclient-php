# Steam API PHP

WIP

## How to use

```php
use SteamClient\Api\SteamAPIWrapper;
use SteamClient\Api\SteamClient;
use SteamClient\Config\Config;

require __DIR__.'/vendor/autoload.php';

$steamConfig = new Config('steamapikey');

// Using the wrapper
$steamAPIWrapper = new SteamApiWrapper($steamConfig);
$availableEndpoints = $steamAPIWrapper->getSupportedAPIList();

print_r($availableEndpoints);

// Call yet non-implemented endpoints
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

print_r($response);

```

### SteamApiWrapper
Wrap API calls and returns object(s) reflecting the response.

### SteamClient
You can use the `SteamClient` class to make calls to the API if you don't want the object wrapping.
Currently returns JSON only.
