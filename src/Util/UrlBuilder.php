<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Util;

class UrlBuilder
{
    /**
     * @param array<string, mixed> $query
     */
    public static function build(string $baseUrl, string $uri, array $query = []): string
    {
        $baseUrl = rtrim($baseUrl, '/');
        $uri = ltrim($uri, '/');

        $url = $baseUrl . '/' . $uri;

        if (!empty($query)) {
            $qs = http_build_query($query, '', '&');

            if ($qs !== '') {
                $url .= '?' . $qs;
            }
        }

        return $url;
    }
}
