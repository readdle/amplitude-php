<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Util;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Util\UrlBuilder;

final class UrlBuilderTest extends TestCase
{
    public function testBuildJoinsAndEncodesQuery(): void
    {
        $url = UrlBuilder::build('https://example.test/', '/path', ['a' => 1, 'b' => 'x y']);
        $this->assertSame('https://example.test/path?a=1&b=x+y', $url);
    }

    public function testBuildWithoutQuery(): void
    {
        $url = UrlBuilder::build('https://example.test', 'path');
        $this->assertSame('https://example.test/path', $url);
    }
}
