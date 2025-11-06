<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http;

final class RequestDebugInfo
{
    private string $url = '';

    private string $method = '';

    /**
     * @var array<string, mixed>
     */
    private array $headers = [];

    /**
     * @var string|array<string, mixed>|null
     */
    private array|string|null $body = null;

    private ?int $curlErrno = null;

    private ?string $curlError = null;

    private ?int $httpCode = null;

    private ?string $responseBodyRaw = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $responseBodyJson = null;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array<string, mixed> $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return string|array<string, mixed>|null
     */
    public function getBody(): array|string|null
    {
        return $this->body;
    }

    /**
     * @param string|array<string, mixed>|null $body
     */
    public function setBody(array|string|null $body): void
    {
        $this->body = $body;
    }

    public function getCurlErrno(): ?int
    {
        return $this->curlErrno;
    }

    public function setCurlErrno(?int $curlErrno): void
    {
        $this->curlErrno = $curlErrno;
    }

    public function getCurlError(): ?string
    {
        return $this->curlError;
    }

    public function setCurlError(?string $curlError): void
    {
        $this->curlError = $curlError;
    }

    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }

    public function setHttpCode(?int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    public function getResponseBodyRaw(): ?string
    {
        return $this->responseBodyRaw;
    }

    public function setResponseBodyRaw(?string $responseBodyRaw): void
    {
        $this->responseBodyRaw = $responseBodyRaw;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getResponseBodyJson(): ?array
    {
        return $this->responseBodyJson;
    }

    /**
     * @param array<string, mixed>|null $responseBodyJson
     */
    public function setResponseBodyJson(?array $responseBodyJson): void
    {
        $this->responseBodyJson = $responseBodyJson;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
