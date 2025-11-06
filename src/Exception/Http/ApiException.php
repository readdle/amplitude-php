<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Exception\Http;

use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Http\RequestDebugInfo;
use Throwable;

class ApiException extends AmplitudeException
{
    protected RequestDebugInfo $debugInfo;

    public function __construct(string $message, RequestDebugInfo $debugInfo, ?Throwable $previous = null)
    {
        $this->debugInfo = $debugInfo;
        parent::__construct($message, 0, $previous);
    }

    public function getDebugInfo(): RequestDebugInfo
    {
        return $this->debugInfo;
    }
}
