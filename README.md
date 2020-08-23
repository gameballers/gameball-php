# Gameball PHP SDK
The Gameball PHP SDK provides convenient access to the Gameball API from applications written in the PHP language.

## Documentation

Please refer to the  [Gameball API docs](https://docs.gameball.co).

### Requirements

-   PHP 5.6.0 and later.

## Installation

You don't need this source code unless you want to modify the SDK. If you just
want to use the SDK, just run:

### Composer
You can install the bindings via [Composer](https://getcomposer.org/). Run the following command:

```sh
composer require gameball/gameball-php
```


To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```PHP
require_once('vendor/autoload.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

* [curl](https://www.php.net/manual/en/book.curl.php) although you can use your own non-cURL client if you prefer
* [json](https://www.php.net/manual/en/book.json.php)
* [mbstring](https://www.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.


## Usage

The SDK needs to be configured with your account's API & Transaction keys available in your [Gameball Dashboard](https://help.gameball.co/en/articles/3467114-get-your-account-integration-details-api-key-and-transaction-key)

### Example

#### Sending an Event

```PHP
$gameball = new \Gameball\GameballClient('Your_API_Key');

$eventRequest = new \Gameball\Models\EventRequest();
$eventRequest->addEvent('place_order');
$eventRequest->addMetaData('place_order','total_amount','100');
$eventRequest->addMetaData('place_order','category',array("electronics","cosmetics"));
$eventRequest->addEvent('review');

$playerRequest = \Gameball\Models\PlayerRequest::factory('player123');
$eventRequest->playerRequest = $playerRequest;

$res= $gameball->event->sendEvent($eventRequest);

// Accessing response data
echo $res->body;
```


### Handling exceptions

Unsuccessful requests raise exceptions. The raised exception will reflect the sort of error that occurred with appropriate message and error code . Please refer to the  [Gameball API docs](https://docs.gameball.co).


## Contribution
The master branch of this repository contains the latest stable release of the SDK.


## Contact
For usage questions\suggestions drop us an email at support[ at ]gameball.co. Please report any bugs as issues.
