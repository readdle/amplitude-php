<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Api;

use JsonException;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Http\Authenticator\PostBodyAuthenticator;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;
use Readdle\AmplitudeClient\Model\IdentifyApi\Identification;

/**
 * Use the Identify API to set the User ID for a particular Device ID or update user properties
 * of a particular user without sending an event. You can change Amplitude default user properties and
 * custom user properties that you have defined.
 *
 * @see https://amplitude.com/docs/apis/analytics/identify
 */
class IdentifyApi extends AbstractApi
{
    public static ?string $authenticator = PostBodyAuthenticator::class;
    public static string $baseUrl = 'https://api2.amplitude.com';

    /**
     * @see https://amplitude.com/docs/apis/analytics/identify#request
     *
     * @throws ApiException
     * @throws MissingCredentialException
     * @throws ValidationException
     */
    public function identify(Identification $identification): ResponseInterface
    {
        return $this->identifyBatch([$identification]);
    }

    /**
     * @see https://amplitude.com/docs/apis/analytics/identify#request
     *
     * @param Identification[] $identifications
     *
     * @throws MissingCredentialException
     * @throws ValidationException
     * @throws ApiException
     */
    public function identifyBatch(array $identifications): ResponseInterface
    {
        if (empty($identifications)) {
            throw new ValidationException('Identifications must not be empty');
        }

        foreach ($identifications as $identification) {
            $identification->validate();
        }

        try {
            $identification = json_encode($identifications, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ValidationException('Failed to JSON-encode identifications payload: ' . $e->getMessage());
        }

        return $this->client->postUrlEncoded('identify', compact('identification'));
    }
}
