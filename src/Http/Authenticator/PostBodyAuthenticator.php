<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Http\Authenticator;

use Readdle\AmplitudeClient\Exception\MissingCredentialException;

class PostBodyAuthenticator extends AbstractAuthenticator
{
    /**
     * @return array<string, string>
     *
     * @throws MissingCredentialException
     */
    public function getAuthParams(): array
    {
        if (empty($this->apiKey)) {
            throw new MissingCredentialException('Missing API key');
        }

        return [
            'api_key' => $this->apiKey,
        ];
    }
}
