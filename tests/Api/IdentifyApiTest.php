<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Api;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Api\IdentifyApi;
use Readdle\AmplitudeClient\Exception\Http\ApiException;
use Readdle\AmplitudeClient\Exception\MissingCredentialException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Model\IdentifyApi\Identification;
use Readdle\AmplitudeClient\Tests\Mocks\ClientMock;

final class IdentifyApiTest extends TestCase
{
    private function makeValidIdentification(): Identification
    {
        $id = new Identification();
        $id->setUserId('user-1');

        return $id;
    }

    /**
     * @throws ValidationException
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function testIdentifyCallsCorrectEndpointAndPayload(): void
    {
        $client = new ClientMock();
        $api = new IdentifyApi($client);

        $identification = $this->makeValidIdentification();
        $api->identify($identification);

        $this->assertSame('POST', $client->lastMethod);
        $this->assertSame('identify', $client->lastUri);
        $this->assertIsArray($client->lastBody);
        $this->assertArrayHasKey('identification', $client->lastBody);
        $this->assertJson($client->lastBody['identification']);
        $decoded = json_decode($client->lastBody['identification'], true);
        $this->assertCount(1, $decoded);
        $this->assertSame($identification->toArray(), $decoded[0]);
    }

    /**
     * @throws MissingCredentialException
     * @throws ApiException
     */
    public function testIdentifyBatchValidatesNonEmpty(): void
    {
        $this->expectException(ValidationException::class);
        $client = new ClientMock();
        $api = new IdentifyApi($client);
        $api->identifyBatch([]);
    }
}
