<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Api;

use DateTime;
use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Api\UserPrivacyApi;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Tests\Mocks\ClientMock;

final class UserPrivacyApiTest extends TestCase
{
    /**
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function testDeleteUsersCallsCorrectEndpoint(): void
    {
        $client = new ClientMock();
        $api = new UserPrivacyApi($client);

        $payload = ['user_ids' => ['u1', 'u2']];
        $api->deleteUsers($payload);

        $this->assertSame('POST', $client->lastMethod);
        $this->assertSame('deletions/users', $client->lastUri);
        $this->assertSame($payload, $client->lastBody);
    }

    /**
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function testGetDeletionJobsBuildsQueryParams(): void
    {
        $client = new ClientMock();
        $api = new UserPrivacyApi($client);

        $start = new DateTime('2023-01-01');
        $end = new DateTime('2023-01-31');
        $api->getDeletionJobs($start, $end);

        $this->assertSame('GET', $client->lastMethod);
        $this->assertSame('deletions/users', $client->lastUri);
        $this->assertSame([
            'start_day' => '2023-01-01',
            'end_day' => '2023-01-31',
        ], $client->lastQuery);
    }
}
