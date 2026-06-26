<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Authenticator;

use Readdle\AmplitudeClient\Exception\MissingCredentialException;

class ApiKeyHeaderAuthenticator extends AbstractAuthenticator implements HeaderAuthenticatorInterface
{
    /**
     * @return array<string, string>
     *
     * @throws MissingCredentialException
     */
    public function getAuthHeader(): array
    {
        if (empty($this->apiSecret)) {
            throw new MissingCredentialException('Missing secret key');
        }

        return [
            'Authorization' => 'Api-Key ' . $this->apiSecret,
        ];
    }
}
