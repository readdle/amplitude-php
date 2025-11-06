<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Model;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Model\Properties;

final class PropertiesTest extends TestCase
{
    public function testSetGetUnsetResetAndSerialize(): void
    {
        $p = new Properties();
        $this->assertTrue($p->isEmpty());

        $p->set('a', 1)->set('b', 'x');
        $this->assertFalse($p->isEmpty());
        $this->assertSame(1, $p->get('a'));
        $this->assertSame('x', $p->get('b'));
        $this->assertNull($p->get('missing'));

        $p->setArray(['c' => true]);
        $this->assertSame(['a' => 1, 'b' => 'x', 'c' => true], $p->toArray());
        $this->assertSame($p->toArray(), $p->jsonSerialize());

        $p->unset('b');
        $this->assertSame(['a' => 1, 'c' => true], $p->toArray());

        $p->reset();
        $this->assertTrue($p->isEmpty());
        $this->assertSame([], $p->toArray());
    }
}
