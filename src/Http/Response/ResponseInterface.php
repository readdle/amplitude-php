<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Response;

interface ResponseInterface
{
    /**
     * @return string|array<string, mixed>|null
     */
    public function getBody(): string|array|null;

    public function getStatusCode(): int;
}
