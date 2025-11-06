<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Model\IdentifyApi;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Model\IdentifyApi\Identification;

final class IdentificationTest extends TestCase
{
    public function testValidateRequiresUserIdOrDeviceId(): void
    {
        $id = new Identification();
        $this->expectException(MissingRequiredPropertiesException::class);
        $id->validate();
    }

    public function testValidatePassesWithUserId(): void
    {
        $id = new Identification();
        $id->setUserId('user-123');
        $id->validate();
        $this->assertTrue(true); // no exception
    }

    public function testValidatePassesWithDeviceId(): void
    {
        $id = new Identification();
        $id->setDeviceId('device-xyz');
        $id->validate();
        $this->assertTrue(true); // no exception
    }

    public function testValidateFailsWhenMixingTopLevelAndOperations(): void
    {
        $id = new Identification();
        $id->setUserId('user-1');
        // top-level user properties set
        $id->userProperties->set('vip', true);
        // and operations set
        $id->userPropertiesOperations->set->set('level', 2);

        $this->expectException(ValidationException::class);
        $id->validate();
    }

    public function testToArraySnakeCaseAndUserPropertiesPrecedence(): void
    {
        $id = new Identification();
        $id->setUserId('u1')
           ->setDeviceId('d1')
           ->setAppVersion('1.2.3')
           ->setDeviceModel('iPhone')
           ->setOsName('iOS');

        // Fill both containers; top-level Properties should win
        $id->userProperties->set('pro', true);
        $id->userPropertiesOperations->set->set('ignored', 'yes');

        $arr = $id->toArray();

        // snake_case checks
        $this->assertSame('u1', $arr['user_id']);
        $this->assertSame('d1', $arr['device_id']);
        $this->assertSame('1.2.3', $arr['app_version']);
        $this->assertSame('iPhone', $arr['device_model']);
        $this->assertSame('iOS', $arr['os_name']);

        // user_properties should reflect top-level Properties, not operations
        $this->assertArrayHasKey('user_properties', $arr);
        $this->assertSame(['pro' => true], $arr['user_properties']);
        $this->assertArrayNotHasKey('$set', $arr['user_properties']);
    }

    public function testToArrayUsesOperationsWhenTopLevelEmpty(): void
    {
        $id = new Identification();
        $id->setUserId('u2');
        // Only operations filled
        $id->userPropertiesOperations->set->set('age', 30);
        $id->userPropertiesOperations->add->set('coins', 5);

        $arr = $id->toArray();
        $this->assertArrayHasKey('user_properties', $arr);
        $this->assertSame([
            '$set' => ['age' => 30],
            '$add' => ['coins' => 5],
        ], $arr['user_properties']);
    }

    public function testToArrayOmitsUserPropertiesWhenBothEmpty(): void
    {
        $id = new Identification();
        $id->setUserId('u3');
        $arr = $id->toArray();
        $this->assertArrayNotHasKey('user_properties', $arr);
    }

    public function testJsonSerializeEqualsToArray(): void
    {
        $id = new Identification();
        $id->setUserId('u4')->setPlatform('web');
        $this->assertSame($id->toArray(), $id->jsonSerialize());
    }
}
