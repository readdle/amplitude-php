<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Amplitude;
use Readdle\AmplitudeClient\Api\HttpApiV2;
use Readdle\AmplitudeClient\Api\IdentifyApi;
use Readdle\AmplitudeClient\Api\UserPrivacyApi;
use Readdle\AmplitudeClient\Exception\AmplitudeException;

final class AmplitudeTest extends TestCase
{
    public function testSingletonReturnsSameInstance(): void
    {
        $a = Amplitude::getInstance('main', 'key1', 'secret1');
        $b = Amplitude::getInstance('main', 'key2', 'secret2');

        $this->assertSame($a, $b);
    }

    public function testAccessingApisReturnsCorrectInstances(): void
    {
        $amp = new Amplitude('apiKey', 'apiSecret');

        $this->assertInstanceOf(HttpApiV2::class, $amp->httpApiV2);
        $this->assertInstanceOf(IdentifyApi::class, $amp->identifyApi);
        $this->assertInstanceOf(UserPrivacyApi::class, $amp->userPrivacyApi);
    }

    public function testInvalidApiThrows(): void
    {
        $this->expectException(AmplitudeException::class);
        $amp = new Amplitude('apiKey');
        /** @phpstan-ignore-next-line */
        // @noinspection PhpUndefinedFieldInspection
        $amp->nonExistingApi;
    }

    public function testBaseUrlOptionOverridesDefault(): void
    {
        $customUrl = 'https://example.test/api';
        $amp = new Amplitude('apiKey', 'secret', [
            'userPrivacyApi' => ['baseUrl' => $customUrl],
        ]);

        $api = $amp->userPrivacyApi;

        $refProp = new ReflectionProperty($api, 'client');
        $refProp->setAccessible(true);
        $client = $refProp->getValue($api);

        $refClient = new ReflectionClass($client);
        $baseUrlProp = $refClient->getProperty('baseUrl');
        $baseUrlProp->setAccessible(true);

        $this->assertSame($customUrl, $baseUrlProp->getValue($client));
    }
}
