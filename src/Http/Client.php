<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http;

use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\Http\ClientException;
use Readdle\AmplitudeClient\Exception\Http\ServerException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Http\Authenticator\AbstractAuthenticator;
use Readdle\AmplitudeClient\Http\Authenticator\HeaderAuthenticator;
use Readdle\AmplitudeClient\Http\Authenticator\PostBodyAuthenticator;
use Readdle\AmplitudeClient\Http\Response\EmptyResponse;
use Readdle\AmplitudeClient\Http\Response\JsonResponse;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;
use Readdle\AmplitudeClient\Http\Response\StringResponse;
use Readdle\AmplitudeClient\Util\UrlBuilder;

class Client
{
    protected const int TIMEOUT = 30;
    protected const int CONNECT_TIMEOUT = 10;

    public function __construct(
        protected string $baseUrl,
        protected ?AbstractAuthenticator $authenticator = null,
    ) {
    }

    /**
     * Universal HTTP request using ext-curl.
     *
     * @param array<string, mixed> $query
     * @param array<string, mixed>|null $body
     * @param array<string, mixed> $headers
     *
     * @throws ApiException
     * @throws MissingCredentialException
     */
    protected function request(
        string $method,
        string $uri,
        array $query = [],
        ?array $body = null,
        array $headers = [],
    ): ResponseInterface {
        $method = strtoupper($method);
        $url = UrlBuilder::build($this->baseUrl, $uri, $query);
        $headers = $this->prepareHeaders($headers);
        $body = $this->prepareBody($body);

        $debugInfo = new RequestDebugInfo();
        $debugInfo->setUrl($url);
        $debugInfo->setMethod($method);
        $debugInfo->setHeaders($headers);
        $debugInfo->setBody($body);

        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => self::CONNECT_TIMEOUT,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HEADER => false,
            CURLOPT_POST => false,
            CURLOPT_HTTPGET => false,
        ];

        if (!empty($headers)) {
            foreach ($headers as $name => $value) {
                $options[CURLOPT_HTTPHEADER][] = $name . ': ' . $value;
            }
        }

        switch ($method) {
            case 'GET':
                $options[CURLOPT_HTTPGET] = true;
                break;

            case 'POST':
                $options[CURLOPT_POST] = true;
                break;

            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST] = $method;
                break;

            default:
                throw new ApiException('Unsupported HTTP method', $debugInfo);
        }

        if (is_array($body)) {
            $contentType = strtolower($headers['Content-Type'] ?? '');

            if ($contentType === 'application/json') {
                $encoded = json_encode($body);
            } else {
                $encoded = http_build_query($body);
            }

            $options[CURLOPT_POSTFIELDS] = $encoded;
        }

        curl_setopt_array($ch, $options);

        $responseBody = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $statusCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        $decoded = is_string($responseBody) ? json_decode($responseBody, true) : null;

        $debugInfo->setCurlErrno($errno ?: null);
        $debugInfo->setCurlError($error ?: null);
        $debugInfo->setHttpCode($statusCode ?: null);
        $debugInfo->setResponseBodyRaw($responseBody ?: null);
        $debugInfo->setResponseBodyJson($decoded ?: null);

        if ($responseBody === false || $errno !== 0) {
            throw new ApiException('HTTP request failed', $debugInfo);
        }

        if ($statusCode < 200 || ($statusCode >= 300 && $statusCode < 400)) {
            throw new ApiException('Wrong response code', $debugInfo);
        }

        if ($statusCode >= 400 && $statusCode < 500) {
            throw new ClientException('Client error', $debugInfo);
        }

        if ($statusCode >= 500 && $statusCode < 600) {
            throw new ServerException('Server error', $debugInfo);
        }

        if (is_array($decoded)) {
            return new JsonResponse($decoded, $statusCode);
        }

        if ($decoded === null && is_string($responseBody) && strlen(trim($responseBody))) {
            return new StringResponse($responseBody, $statusCode);
        }

        return new EmptyResponse($statusCode);
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $headers
     *
     * @throws ApiException|MissingCredentialException
     */
    public function get(string $uri, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->request('GET', $uri, $query, null, $headers);
    }

    /**
     * @param array<string, mixed>|null $body
     *
     * @throws ApiException|MissingCredentialException
     */
    public function postJson(string $uri, ?array $body = null): ResponseInterface
    {
        return $this->request('POST', $uri, [], $body, ['Content-Type' => 'application/json']);
    }

    /**
     * @param array<string, mixed>|null $body
     *
     * @throws ApiException|MissingCredentialException
     */
    public function postUrlEncoded(string $uri, ?array $body = null): ResponseInterface
    {
        return $this->request('POST', $uri, [], $body, ['Content-Type' => 'application/x-www-form-urlencoded']);
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     *
     * @throws MissingCredentialException
     */
    protected function prepareHeaders(array $headers): array
    {
        if ($this->authenticator instanceof HeaderAuthenticator) {
            $headers = array_merge($headers, $this->authenticator->getAuthHeader());
        }

        return $headers;
    }

    /**
     * @param array<string, mixed>|null $body
     *
     * @return array<string, mixed>|null
     *
     * @throws MissingCredentialException
     */
    protected function prepareBody(?array $body): ?array
    {
        if ($this->authenticator instanceof PostBodyAuthenticator) {
            return array_merge($body ?? [], $this->authenticator->getAuthParams());
        }

        return $body;
    }
}
