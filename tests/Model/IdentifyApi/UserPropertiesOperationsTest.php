<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Model\IdentifyApi;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Model\IdentifyApi\UserPropertiesOperations;

final class UserPropertiesOperationsTest extends TestCase
{
    public function testInitiallyEmpty(): void
    {
        $ops = new UserPropertiesOperations();
        $this->assertTrue($ops->isEmpty());
        $this->assertSame([], $ops->toArray());
        $this->assertSame($ops->toArray(), $ops->jsonSerialize());
    }

    public function testSettingEachOperationProducesExpectedKeys(): void
    {
        $ops = new UserPropertiesOperations();

        $ops->set->set('name', 'Alice');
        $ops->setOnce->set('signup_at', 1700000000);
        $ops->add->set('coins', 5);
        $ops->append->set('tags', 'new');
        $ops->prepend->set('tags', 'vip');
        $ops->unset->set('legacy_field', true);
        $ops->preInsert->set('interests', ['reading']);
        $ops->postInsert->set('interests', ['coding']);
        $ops->remove->set('badges', ['old']);

        $this->assertFalse($ops->isEmpty());

        $arr = $ops->toArray();

        $this->assertArrayHasKey('$set', $arr);
        $this->assertArrayHasKey('$setOnce', $arr);
        $this->assertArrayHasKey('$add', $arr);
        $this->assertArrayHasKey('$append', $arr);
        $this->assertArrayHasKey('$prepend', $arr);
        $this->assertArrayHasKey('$unset', $arr);
        $this->assertArrayHasKey('$preInsert', $arr);
        $this->assertArrayHasKey('$postInsert', $arr);
        $this->assertArrayHasKey('$remove', $arr);

        $this->assertSame(['name' => 'Alice'], $arr['$set']);
        $this->assertSame(['signup_at' => 1700000000], $arr['$setOnce']);
        $this->assertSame(['coins' => 5], $arr['$add']);
        $this->assertSame(['tags' => 'new'], $arr['$append']);
        $this->assertSame(['tags' => 'vip'], $arr['$prepend']);
        $this->assertSame(['legacy_field' => true], $arr['$unset']);
        $this->assertSame(['interests' => ['reading']], $arr['$preInsert']);
        $this->assertSame(['interests' => ['coding']], $arr['$postInsert']);
        $this->assertSame(['badges' => ['old']], $arr['$remove']);

        $this->assertSame($arr, $ops->jsonSerialize());
    }

    public function testPartialPopulationIncludesOnlyThoseKeys(): void
    {
        $ops = new UserPropertiesOperations();

        // Only set two operations
        $ops->add->set('xp', 10);
        $ops->remove->set('roles', ['guest']);

        $this->assertFalse($ops->isEmpty());

        $arr = $ops->toArray();
        $this->assertSame([
            '$add' => ['xp' => 10],
            '$remove' => ['roles' => ['guest']],
        ], $arr);
    }
}
