<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Api;

use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Http\Authenticator\ApiKeyHeaderAuthenticator;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;

/**
 * The User Profile API exposes a user's profile data, including user properties,
 * recommendations, cohort IDs, computations, and prediction propensities.
 *
 * @see https://amplitude.com/docs/apis/analytics/user-profile
 */
class UserProfileApi extends AbstractApi
{
    public static ?string $authenticator = ApiKeyHeaderAuthenticator::class;
    public static string $baseUrl = 'https://profile-api.amplitude.com';

    /**
     * @see https://amplitude.com/docs/apis/analytics/user-profile#get-user-properties
     *
     * @throws MissingCredentialException
     * @throws ApiException
     * @throws ValidationException
     */
    public function getUserProperties(?string $userId = null, ?string $deviceId = null): ResponseInterface
    {
        if (empty($userId) && empty($deviceId)) {
            throw new ValidationException('Either userId or deviceId must be provided');
        }

        $query = [
            'get_amp_props' => 'true',
        ];

        if ($userId !== null && $userId !== '') {
            $query['user_id'] = $userId;
        }

        if ($deviceId !== null && $deviceId !== '') {
            $query['device_id'] = $deviceId;
        }

        return $this->client->get('/v1/userprofile', $query);
    }
}
