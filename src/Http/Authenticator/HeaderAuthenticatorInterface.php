<?php
declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Authenticator;

use Readdle\AmplitudeClient\Exception\MissingCredentialException;

interface HeaderAuthenticatorInterface
{
    /**
     * @return array<string, string>
     *
     * @throws MissingCredentialException
     */
    public function getAuthHeader(): array;
}
