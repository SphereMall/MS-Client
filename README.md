# SphereMall Gateway PHP SDK

Official PHP SDK for integrating with **SphereMall Product**.
[Official documentation](https://spheremall.atlassian.net/wiki/spaces/MIC/pages)

### [Version 2.7.23](https://spheremall.atlassian.net/browse/M20-80)
## Add CRUD wrapping for Marketing microservice

### [Version 2.7.22](https://spheremall.atlassian.net/browse/M20-80)
## created Categories and EntityGroups resource

### [Version 2.7.21](https://github.com/SphereMall/PHP-MS-Client/wiki/0.-SDK-Changelogs#version-1016)
## Extend attribute entity with attributeTypeId

### [Version 2.7.19.2](https://github.com/SphereMall/PHP-MS-Client/wiki/0.-SDK-Changelogs#version-1016)
## Add CRUD wrapping for CatalogItemAttributes

### [Version 2.7.19.1](https://github.com/SphereMall/PHP-MS-Client/wiki/0.-SDK-Changelogs#version-1016)
## !!! Indexer Microservice version: 2.4.0 +

=======
## Installation

You can install the package manually or by adding it to your `composer.json`:
```
{
  "require": {
      "spheremall/ms-client": "^1.0"
  }
}
```

## Instantiating the SDK Client:

Pass in the configuration to the client:

```php
$client = new Client([
            'gatewayUrl' => 'API_GATEWAY_URL',
            'clientId'   => 'API_CLIENT_ID',
            'secretKey'  => 'API_SECRET_KEY'
        ]);
```

## Using the client with base Resources functionality
* [Multiple Resources](https://github.com/SphereMall/PHP-MS-Client/wiki/1.-Multiple-Resources)
* [Single Resource by ID](https://github.com/SphereMall/PHP-MS-Client/wiki/2.-Single-Resource-by-ID)
* [Limiting and Offsetting Results](https://github.com/SphereMall/PHP-MS-Client/wiki/3.-Limiting-and-Offsetting-Results)
* [Filtering result with specific fields](https://github.com/SphereMall/PHP-MS-Client/wiki/4.-Filtering-result-with-specific-fields)
* [Sorting Results](https://github.com/SphereMall/PHP-MS-Client/wiki/5.-Sorting-Results)
* [Counting Results](https://github.com/SphereMall/PHP-MS-Client/wiki/6.-Counting-Results)
* [Product Resource](https://github.com/SphereMall/PHP-MS-Client/wiki/7.-Product-Resource)
* [Get full](https://github.com/SphereMall/PHP-MS-Client/wiki/7.1.-Get-full)
* [Shop](https://github.com/SphereMall/PHP-MS-Client/wiki/8.-Shop-service)
* [ElasticSearch](https://github.com/SphereMall/PHP-MS-Client/wiki/9.-ElasticSearch)
