<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Api;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Api\UserProfileApi;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Tests\Mocks\ClientMock;

final class UserProfileApiTest extends TestCase
{
    /**
     * @throws MissingCredentialException
     * @throws ApiException
     * @throws ValidationException
     */
    public function testGetUserPropertiesBuildsQueryParams(): void
    {
        $client = new ClientMock();
        $api = new UserProfileApi($client);

        $api->getUserProperties('user-1');

        $this->assertSame('GET', $client->lastMethod);
        $this->assertSame('/v1/userprofile', $client->lastUri);
        $this->assertSame([
            'get_amp_props' => 'true',
            'user_id' => 'user-1',
        ], $client->lastQuery);
    }

    /**
     * @throws MissingCredentialException
     * @throws ApiException
     * @throws ValidationException
     */
    public function testGetUserPropertiesAllowsDeviceId(): void
    {
        $client = new ClientMock();
        $api = new UserProfileApi($client);

        $api->getUserProperties(null, 'device-1');

        $this->assertSame([
            'get_amp_props' => 'true',
            'device_id' => 'device-1',
        ], $client->lastQuery);
    }

    /**
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function testGetUserPropertiesRequiresAnIdentifier(): void
    {
        $this->expectException(ValidationException::class);

        $client = new ClientMock();
        $api = new UserProfileApi($client);
        $api->getUserProperties();
    }
}
