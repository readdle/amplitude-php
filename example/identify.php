<?php

declare(strict_types=1);

// Example script for local testing of Amplitude Identify API
// Usage:
//   php example/identify.php [apiKey] [userId] [deviceId]

require __DIR__ . '/../vendor/autoload.php';

use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Model\IdentifyApi\Identification;

$apiKey = $argv[1] ?? null;
$apiSecret = null; // Secret is not required
$userId = $argv[2] ?? null;
$deviceId = $argv[3] ?? null;

if (empty($apiKey)) {
    fwrite(STDERR, "Missing API key. Pass it via your shell.\n");
    exit(2);
}

if (empty($userId) && empty($deviceId)) {
    fwrite(STDERR, "Provide userId or deviceId (or both).\n");
    exit(2);
}

$identification = new Identification();
$identification->setUserId($userId);
$identification->setDeviceId($deviceId);

// Example: set top-level user properties
$identification->userProperties->set('property1', 'value1');
$identification->userProperties->set('property2', 'value2');

// Example: alternatively use operations
// $identification->userPropertiesOperations->setOnce->set('property1', 'value1');
// $identification->userPropertiesOperations->set->set('property2', 'value2');
// $identification->userPropertiesOperations->add->set('some_number', 1);

$amp = new Amplitude($apiKey, $apiSecret);

try {
    $resp = $amp->identifyApi->identify($identification);
    echo print_r($resp->getBody(), true);
} catch (ApiException $e) {
    echo $e->getMessage();
    echo print_r($e->getDebugInfo(), true);
} catch (AmplitudeException $e) {
    echo $e->getMessage();
}
