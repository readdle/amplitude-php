<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Response;

final readonly class JsonResponse implements ResponseInterface
{
    /**
     * @param array<string, mixed> $body
     */
    public function __construct(private array $body, private int $statusCode)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
