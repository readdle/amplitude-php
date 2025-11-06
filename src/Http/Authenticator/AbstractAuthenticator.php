<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Authenticator;

abstract class AbstractAuthenticator
{
    public function __construct(
        protected string $apiKey,
        protected ?string $apiSecret = null,
    ) {
    }
}
