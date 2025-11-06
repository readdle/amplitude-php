<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Mocks;

use Readdle\AmplitudeClient\Http\Client;
use Readdle\AmplitudeClient\Http\Response\JsonResponse;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;

class ClientMock extends Client
{
    public string $lastMethod = '';
    public string $lastUri = '';
    public array $lastQuery = [];
    public ?array $lastBody = null;
    public array $lastHeaders = [];

    public function __construct()
    {
        parent::__construct('http://localhost', null);
    }

    public function get(string $uri, array $query = [], array $headers = []): ResponseInterface
    {
        $this->lastMethod = 'GET';
        $this->lastUri = $uri;
        $this->lastQuery = $query;
        $this->lastHeaders = $headers;

        return new JsonResponse(['ok' => true], 200);
    }

    public function postJson(string $uri, ?array $body = null): ResponseInterface
    {
        $this->lastMethod = 'POST';
        $this->lastUri = $uri;
        $this->lastBody = $body;
        $this->lastHeaders = ['Content-Type' => 'application/json'];

        return new JsonResponse(['ok' => true], 200);
    }

    public function postUrlEncoded(string $uri, ?array $body = null): ResponseInterface
    {
        $this->lastMethod = 'POST';
        $this->lastUri = $uri;
        $this->lastBody = $body;
        $this->lastHeaders = ['Content-Type' => 'application/x-www-form-urlencoded'];

        return new JsonResponse(['ok' => true], 200);
    }
}
