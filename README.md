# Steam API PHP

WIP

## How to use

```php
use SteamClient\Api\SteamAPIHandler;
use SteamClient\Config\Config;

require __DIR__.'/vendor/autoload.php';

$steamConfig = new Config('steamapikey');
$steamAPIHandler = new SteamApiHandler($steamConfig);
$availableEndpoints = $steamAPIHandler->getSupportedAPIList();

print_r($availableEndpoints);
```
