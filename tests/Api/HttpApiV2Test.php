<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Api;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Api\HttpApiV2;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Model\HttpApiV2\Event;
use Readdle\AmplitudeClient\Tests\Mocks\ClientMock;

final class HttpApiV2Test extends TestCase
{
    private function makeValidEvent(): Event
    {
        $event = new Event();
        $event->setEventType('test_event');
        $event->setUserId('user-1');
        return $event;
    }

    /**
     * @throws MissingCredentialException
     * @throws MissingRequiredPropertiesException
     * @throws ValidationException
     * @throws ApiException
     */
    public function testSendEventCallsCorrectEndpointAndPayload(): void
    {
        $client = new ClientMock();
        $api = new HttpApiV2($client);

        $event = $this->makeValidEvent();
        $api->sendEvent($event);

        $this->assertSame('POST', $client->lastMethod);
        $this->assertSame('/2/httpapi', $client->lastUri);
        $this->assertIsArray($client->lastBody);
        $this->assertArrayHasKey('events', $client->lastBody);
        $this->assertCount(1, $client->lastBody['events']);
        $this->assertSame($event->toArray(), $client->lastBody['events'][0]);
    }

    /**
     * @throws MissingCredentialException
     * @throws ValidationException
     * @throws ApiException
     */
    public function testSendEventsValidatesEvent(): void
    {
        $this->expectException(MissingRequiredPropertiesException::class);
        $client = new ClientMock();
        $api = new HttpApiV2($client);
        $invalid = new Event(); // missing required fields
        $api->sendEvents([$invalid]);
    }
}
