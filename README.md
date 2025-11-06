# Amplitude Client (PHP)

A lightweight PHP SDK for Amplitude

- Supported APIs:
  - [Analytics HTTP API v2](https://amplitude.com/docs/apis/analytics/http-v2) (send events)
  - [Identify API](https://amplitude.com/docs/apis/analytics/identify) (set/update user properties)
  - [User Privacy API](https://amplitude.com/docs/apis/analytics/user-privacy) (delete users, get deletion job statuses)
- Requirements: PHP 8.3+, ext-curl, ext-json

## Installation

Use Composer:

```bash
composer require readdle/ps-cs-amplitude-client-php
```

## Quick Start

```php
use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Model\HttpApiV2\Event;
use Readdle\AmplitudeClient\Model\IdentifyApi\Identification;

$apiKey = 'YOUR_AMPLITUDE_API_KEY';
$apiSecret = 'YOUR_AMPLITUDE_SECRET'; // optional for HTTP API v2 and Identify API

$amplitude = new Amplitude($apiKey, $apiSecret);

// 1) Send a single event (HTTP API v2)
$event = new Event();
$event->setUserId('user-123');
$event->setEventType('purchase');
$event->setRevenue(9.99);

$amplitude->httpApiV2->sendEvent($event);

// 2) Identify: set/update user properties
$identification = new Identification();
$identification->setUserId('user-123');
$identification->userProperties->set('prop1', 'value1');
$identification->userProperties->set('prop2', 'value2');

$amplitude->identifyApi->identify($identification);

// 3) User Privacy API: create a deletion job
$request = [
    'user_ids' => ['user-123', 'user-456'],
    // see Amplitude official docs for other fields
];
$amplitude->userPrivacyApi->deleteUsers($request);
```

The example/ directory contains runnable scripts that demonstrate all API calls:

## Configuration

The Amplitude class lets you override base URLs for each API via the $options argument:

```php
use Readdle\AmplitudeClient\Amplitude;

$amplitude = new Amplitude(
    'API_KEY',
    'API_SECRET',
    [
        'httpApiV2' => [ 'baseUrl' => 'https://some.proxy.com' ],
        'identifyApi' => [ 'baseUrl' => 'https://some.proxy2.com' ],
        'userPrivacyApi' => [ 'baseUrl' => 'https://some.proxy3.com' ],
    ]
);
```

A named singleton instance is also available:

```php
$amplitude = Amplitude::getInstance('default', 'API_KEY', 'API_SECRET');
```

## Running Tests

This project uses PHP-CS-Fixer, PHPStan and PHPUnit tests.

```bash
composer run cs:check
composer run cs:fix
composer run phpstan
composer run test
```

## License

MIT
