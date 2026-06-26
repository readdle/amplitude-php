<?php

declare(strict_types=1);

// Example script for local testing of Amplitude User Profile API
// Usage:
//   php example/userProfile.php [apiKey] [apiSecret] [userId] [deviceId]
// Examples:
//   php example/userProfile.php YOUR_API_KEY YOUR_SECRET user-123
//   php example/userProfile.php YOUR_API_KEY YOUR_SECRET '' device-123

require __DIR__ . '/../vendor/autoload.php';

use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\ValidationException;

$apiKey = $argv[1] ?? null;
$apiSecret = $argv[2] ?? null;
$userId = $argv[3] ?? null;
$deviceId = $argv[4] ?? null;

if (empty($apiKey) || empty($apiSecret)) {
    fwrite(STDERR, "Missing API key or secret. Usage: php example/userProfile.php [apiKey] [apiSecret] [userId] [deviceId]\n");
    exit(2);
}

$amp = new Amplitude($apiKey, $apiSecret);

try {
    $response = $amp->userProfileApi->getUserProperties($userId ?: null, $deviceId ?: null);
    echo print_r($response->getBody(), true);
} catch (ValidationException $e) {
    echo $e->getMessage();
} catch (ApiException $e) {
    echo $e->getMessage();
    echo print_r($e->getDebugInfo(), true);
} catch (AmplitudeException $e) {
    echo $e->getMessage();
}
