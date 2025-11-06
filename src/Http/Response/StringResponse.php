<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Response;

final readonly class StringResponse implements ResponseInterface
{
    public function __construct(private string $body, private int $statusCode)
    {
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
