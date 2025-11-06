<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Http;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Http\Authenticator\HeaderAuthenticator;
use Readdle\AmplitudeClient\Http\Authenticator\PostBodyAuthenticator;
use Readdle\AmplitudeClient\Http\Client;
use ReflectionClass;
use ReflectionException;

class ClientAuthTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    private function exposePrepareHeaders(Client $client, array $headers): array
    {
        $ref = new ReflectionClass($client);
        $m = $ref->getMethod('prepareHeaders');
        $m->setAccessible(true);
        return $m->invoke($client, $headers);
    }

    /**
     * @throws ReflectionException
     */
    private function exposePrepareBody(Client $client, ?array $body): ?array
    {
        $ref = new ReflectionClass($client);
        $m = $ref->getMethod('prepareBody');
        $m->setAccessible(true);
        return $m->invoke($client, $body);
    }

    /**
     * @throws ReflectionException
     */
    public function testHeaderAuthenticatorAddsAuthorizationHeader(): void
    {
        $auth = new HeaderAuthenticator('apiKey', 'secret');
        $client = new Client('https://example.test', $auth);

        $headers = $this->exposePrepareHeaders($client, ['X-Test' => '1']);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertSame('1', $headers['X-Test']);
        $this->assertStringStartsWith('Basic ', $headers['Authorization']);
    }

    /**
     * @throws ReflectionException
     */
    public function testHeaderAuthenticatorMissingSecretThrows(): void
    {
        $this->expectException(MissingCredentialException::class);
        $auth = new HeaderAuthenticator('apiKey', null);
        $client = new Client('https://example.test', $auth);
        $this->exposePrepareHeaders($client, []);
    }

    /**
     * @throws ReflectionException
     */
    public function testPostBodyAuthenticatorAddsApiKeyToBody(): void
    {
        $auth = new PostBodyAuthenticator('apiKey');
        $client = new Client('https://example.test', $auth);

        $body = $this->exposePrepareBody($client, ['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar', 'api_key' => 'apiKey'], $body);
    }

    /**
     * @throws ReflectionException
     */
    public function testPostBodyAuthenticatorMissingKeyThrows(): void
    {
        $this->expectException(MissingCredentialException::class);
        $auth = new PostBodyAuthenticator('');
        $client = new Client('https://example.test', $auth);
        $this->exposePrepareBody($client, null);
    }
}
