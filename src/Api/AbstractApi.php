<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Api;

use Readdle\AmplitudeClient\Http\Client;

class AbstractApi
{
    protected Client $client;
    public static ?string $authenticator = null;
    public static string $baseUrl = '';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
