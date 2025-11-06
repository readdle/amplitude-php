<?php

declare(strict_types=1);

// Example script for local testing of Amplitude HTTP API V2 (events)
// Usage:
//   php example/httpApiV2.php [apiKey] [eventType] [userId] [deviceId]

require __DIR__ . '/../vendor/autoload.php';

use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Model\HttpApiV2\Event;

$apiKey = $argv[1] ?? null;
$apiSecret = null; // Secret is not required
$eventType = $argv[2] ?? null;
$userId = $argv[3] ?? null;
$deviceId = $argv[4] ?? null;

if (empty($apiKey)) {
    fwrite(STDERR, "Missing API key. Pass it via your shell.\n");
    exit(2);
}

if (empty($userId) && empty($deviceId)) {
    fwrite(STDERR, "Provide userId or deviceId (or both).\n");
    exit(2);
}

$event = new Event();
$event->setEventType($eventType);
$event->setUserId($userId);
$event->setDeviceId($deviceId);
$event->eventProperties->set('source', 'httpApiV2_example_script');
$event->userProperties->set('property1', 'value1');
$event->userProperties->set('property2', 'value2');

$amp = new Amplitude($apiKey, $apiSecret);

try {
    $resp = $amp->httpApiV2->sendEvent($event);
    echo print_r($resp->getBody(), true);
} catch (ApiException $e) {
    echo $e->getMessage();
    echo print_r($e->getDebugInfo(), true);
} catch (AmplitudeException $e) {
    echo $e->getMessage();
}
