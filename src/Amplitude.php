<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient;

use Readdle\AmplitudeClient\Api\AbstractApi;
use Readdle\AmplitudeClient\Api\HttpApiV2;
use Readdle\AmplitudeClient\Api\IdentifyApi;
use Readdle\AmplitudeClient\Api\UserPrivacyApi;
use Readdle\AmplitudeClient\Exception\AmplitudeException;
use Readdle\AmplitudeClient\Http\Client;

/**
 * @property HttpApiV2 $httpApiV2
 * @property IdentifyApi $identifyApi
 * @property UserPrivacyApi $userPrivacyApi
 */
class Amplitude
{
    protected ?string $apiKey = null;
    protected ?string $apiSecret = null;

    /**
     * @var array<string,mixed>
     */
    protected array $options = [
        'httpApiV2' => [
            'baseUrl' => null,
        ],
        'identifyApi' => [
            'baseUrl' => null,
        ],
        'userPrivacyApi' => [
            'baseUrl' => null,
        ],
    ];

    /**
     * @var Amplitude[]
     */
    protected static array $instances = [];

    /**
     * @var array<string, class-string<AbstractApi>>
     */
    protected array $apiClasses = [
        'httpApiV2' => HttpApiV2::class,
        'identifyApi' => IdentifyApi::class,
        'userPrivacyApi' => UserPrivacyApi::class,
    ];

    /**
     * @var AbstractApi[]
     */
    protected array $apiInstances = [];

    /**
     * Singleton to get a named instance.
     *
     * @param array<string, mixed> $options
     */
    public static function getInstance(
        string $instanceName,
        string $apiKey,
        ?string $apiSecret = null,
        array $options = [],
    ): self {
        if (empty(self::$instances[$instanceName])) {
            self::$instances[$instanceName] = new self($apiKey, $apiSecret, $options);
        }

        return self::$instances[$instanceName];
    }

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(string $apiKey, ?string $apiSecret = null, array $options = [])
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->options = $options;
    }

    /**
     * @throws AmplitudeException
     */
    public function __get(string $name): AbstractApi
    {
        return $this->getApi($name);
    }

    /**
     * @throws AmplitudeException
     */
    protected function getApi(string $name): AbstractApi
    {
        if (!isset($this->apiClasses[$name])) {
            throw new AmplitudeException("Api $name do not exist");
        }

        if (isset($this->apiInstances[$name])) {
            return $this->apiInstances[$name];
        }

        $apiClass = $this->apiClasses[$name];

        $authenticatorClass = $apiClass::$authenticator;
        $authenticator = null;

        if (!is_null($authenticatorClass)) {
            $authenticator = new $authenticatorClass($this->apiKey, $this->apiSecret);
        }

        $baseUrl = $this->options[$name]['baseUrl'] ?? $apiClass::$baseUrl;

        $client = new Client($baseUrl, $authenticator);

        $this->apiInstances[$name] = new $apiClass($client);

        return $this->apiInstances[$name];
    }
}
