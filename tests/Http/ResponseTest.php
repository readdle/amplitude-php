<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Tests\Http;

use PHPUnit\Framework\TestCase;
use Readdle\AmplitudeClient\Http\RequestDebugInfo;
use Readdle\AmplitudeClient\Http\Response\EmptyResponse;
use Readdle\AmplitudeClient\Http\Response\JsonResponse;
use Readdle\AmplitudeClient\Http\Response\StringResponse;

final class ResponseTest extends TestCase
{
    public function testJsonResponse(): void
    {
        $r = new JsonResponse(['a' => 1], 200);
        $this->assertSame(['a' => 1], $r->getBody());
        $this->assertSame(200, $r->getStatusCode());
    }

    public function testStringResponse(): void
    {
        $r = new StringResponse('ok', 201);
        $this->assertSame('ok', $r->getBody());
        $this->assertSame(201, $r->getStatusCode());
    }

    public function testEmptyResponse(): void
    {
        $r = new EmptyResponse(204);
        $this->assertNull($r->getBody());
        $this->assertSame(204, $r->getStatusCode());
    }

    public function testRequestDebugInfoToArray(): void
    {
        $d = new RequestDebugInfo();
        $d->setUrl('u');
        $d->setMethod('GET');
        $d->setHeaders(['h' => 'v']);
        $d->setBody(['b' => 1]);
        $d->setCurlErrno(0);
        $d->setCurlError(null);
        $d->setHttpCode(200);
        $d->setResponseBodyRaw('raw');
        $d->setResponseBodyJson(['x' => 2]);

        $arr = $d->toArray();
        $this->assertSame('u', $arr['url']);
        $this->assertSame('GET', $arr['method']);
        $this->assertSame(['h' => 'v'], $arr['headers']);
        $this->assertSame(['b' => 1], $arr['body']);
        $this->assertSame(0, $arr['curlErrno']);
        $this->assertSame(null, $arr['curlError']);
        $this->assertSame(200, $arr['httpCode']);
        $this->assertSame('raw', $arr['responseBodyRaw']);
        $this->assertSame(['x' => 2], $arr['responseBodyJson']);
    }
}
