<?php

declare(strict_types=1);

// Example script for local testing of Amplitude User Privacy API
// Usage:
//   php example/userPrivacy.php [apiKey] [apiSecret] delete '<json_payload>'
//   php example/userPrivacy.php [apiKey] [apiSecret] list [start_day] [end_day]
// Examples:
//   php example/userPrivacy.php YOUR_API_KEY YOUR_SECRET delete '{"user_ids":["user-1","user-2"]}'
//   php example/userPrivacy.php YOUR_API_KEY YOUR_SECRET list 2025-01-01 2025-01-31

require __DIR__ . '/../vendor/autoload.php';

use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Exception\Http\ApiException;

$apiKey = $argv[1] ?? null;
$apiSecret = $argv[2] ?? null; // required for User Privacy API auth
$action = strtolower($argv[3] ?? '');

if (empty($apiKey) || empty($apiSecret)) {
    fwrite(STDERR, "Missing API key or secret. Usage: php example/userPrivacy.php [apiKey] [apiSecret] <delete|list> ...\n");
    exit(2);
}

$amp = new Amplitude($apiKey, $apiSecret);

try {
    switch ($action) {
        case 'delete':
            $json = $argv[4] ?? '';

            if ($json === '') {
                fwrite(STDERR, "Provide JSON payload for delete, e.g. {\"user_ids\":[\"user-1\"]}\n");
                exit(2);
            }
            $payload = json_decode($json, true);

            if (!is_array($payload)) {
                fwrite(STDERR, "Invalid JSON payload.\n");
                exit(2);
            }
            $resp = $amp->userPrivacyApi->deleteUsers($payload);
            echo print_r($resp->getBody(), true);
            break;

        case 'list':
            $startStr = $argv[4] ?? null;
            $endStr = $argv[5] ?? null;

            if (empty($startStr) || empty($endStr)) {
                fwrite(STDERR, "Provide start_day and end_day in YYYY-MM-DD format.\n");
                exit(2);
            }
            $start = new DateTime($startStr);
            $end = new DateTime($endStr);
            $resp = $amp->userPrivacyApi->getDeletionJobs($start, $end);
            echo print_r($resp->getBody(), true);
            break;

        default:
            fwrite(STDERR, "Unknown action. Use 'delete' or 'list'.\n");
            exit(2);
    }
} catch (ApiException $e) {
    echo $e->getMessage();
    echo print_r($e->getDebugInfo(), true);
} catch (AmplitudeException $e) {
    echo $e->getMessage();
}
