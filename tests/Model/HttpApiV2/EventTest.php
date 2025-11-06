<?php

declare(strict_types=1);

namespace Model\HttpApiV2;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Model\HttpApiV2\Event;

final class EventTest extends TestCase
{
    public function testValidateRequiresEventTypeAndOneId(): void
    {
        $e = new Event();
        $this->expectException(MissingRequiredPropertiesException::class);
        $e->validate();
    }

    /**
     * @throws MissingRequiredPropertiesException
     */
    public function testValidatePassesWithEventTypeAndUserId(): void
    {
        $e = new Event();
        $e->setEventType('login')->setUserId('u1');
        $e->validate();
        $this->assertTrue(true); // no exception
    }

    public function testToArraySerializesSnakeCaseAndProperties(): void
    {
        $e = new Event();
        $e->setEventType('purchase')
          ->setUserId('u1')
          ->setDeviceModel('iPhone')
          ->setProductId('SKU123')
          ->setRevenueType('rev');

        $e->eventProperties->set('color', 'red');
        $e->userProperties->set('vip', true);

        $arr = $e->toArray();

        $this->assertSame('purchase', $arr['event_type']);
        $this->assertSame('u1', $arr['user_id']);
        $this->assertSame('iPhone', $arr['device_model']);

        // ensure some keys are not converted to snake case
        $this->assertArrayHasKey('productId', $arr);
        $this->assertArrayHasKey('revenueType', $arr);

        $this->assertSame(['color' => 'red'], $arr['event_properties']);
        $this->assertSame(['vip' => true], $arr['user_properties']);
    }
}
