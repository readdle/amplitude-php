<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Api;

use DateTime;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Http\Authenticator\HeaderAuthenticator;
use Readdle\AmplitudeClient\Http\Response\ResponseInterface;

/**
 * The User Privacy API helps you comply with end-user data
 * deletion requests mandated by global privacy laws such as GDPR and CCPA.
 * The API lets you programmatically submit requests to delete all data for a set of known Amplitude IDs or User IDs.
 *
 * @see https://amplitude.com/docs/apis/analytics/user-privacy
 */
class UserPrivacyApi extends AbstractApi
{
    public static ?string $authenticator = HeaderAuthenticator::class;
    public static string $baseUrl = 'https://amplitude.com/api/2';

    /**
     * @see https://amplitude.com/docs/apis/analytics/user-privacy#delete-users
     *
     * @param array<string, mixed> $request
     *
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function deleteUsers(array $request): ResponseInterface
    {
        return $this->client->postJson('deletions/users', $request);
    }

    /**
     * @see https://amplitude.com/docs/apis/analytics/user-privacy#get-deletion-jobs
     *
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function getDeletionJobs(DateTime $start, DateTime $end): ResponseInterface
    {
        return $this->client->get('deletions/users', [
            'start_day' => $start->format('Y-m-d'),
            'end_day' => $end->format('Y-m-d'),
        ]);
    }
}
