<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Response;

final readonly class EmptyResponse implements ResponseInterface
{
    public function __construct(private int $statusCode)
    {
    }

    public function getBody(): null
    {
        return null;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
