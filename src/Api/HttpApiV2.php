<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Api;

use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Http\Authenticator\PostBodyAuthenticator;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;
use Readdle\AmplitudeClient\Model\HttpApiV2\Event;

/**
 * Use the HTTP V2 API to send data directly from your server to the HTTP V2 endpoint.
 *
 * @see https://amplitude.com/docs/apis/analytics/http-v2
 */
class HttpApiV2 extends AbstractApi
{
    public static ?string $authenticator = PostBodyAuthenticator::class;
    public static string $baseUrl = 'https://api2.amplitude.com';

    /**
     * @var Event[]
     */
    protected array $queue = [];

    /**
     * @see https://amplitude.com/docs/apis/analytics/http-v2#request
     *
     * @throws MissingCredentialException
     * @throws MissingRequiredPropertiesException
     * @throws ApiException
     * @throws ValidationException
     */
    public function sendEvent(Event $event): ResponseInterface
    {
        return $this->sendEvents([$event]);
    }

    /**
     * @see https://amplitude.com/docs/apis/analytics/http-v2#request
     *
     * @param Event[] $events
     *
     * @throws MissingCredentialException
     * @throws ApiException
     * @throws MissingRequiredPropertiesException
     * @throws ValidationException
     */
    public function sendEvents(array $events): ResponseInterface
    {
        foreach ($events as $event) {
            $event->validate();
        }

        $events = array_map(fn (Event $event): array => $event->toArray(), $events);

        return $this->client->postJson('/2/httpapi', compact('events'));
    }
}
