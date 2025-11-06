<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Authenticator;

use Readdle\AmplitudeClient\Exception\MissingCredentialException;

class HeaderAuthenticator extends AbstractAuthenticator
{
    /**
     * @return array<string, string>
     *
     * @throws MissingCredentialException
     */
    public function getAuthHeader(): array
    {
        if (empty($this->apiKey)) {
            throw new MissingCredentialException('Missing API key');
        }

        if (empty($this->apiSecret)) {
            throw new MissingCredentialException('Missing secret key');
        }

        $authToken = base64_encode($this->apiKey . ':' . $this->apiSecret);

        return [
            'Authorization' => 'Basic ' . $authToken,
        ];
    }
}
