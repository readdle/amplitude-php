<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Model\IdentifyApi;

use JsonSerializable;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Exception\ValidationException;
use Readdle\AmplitudeClient\Model\Properties;

class Identification implements JsonSerializable
{
    protected ?string $userId = null;
    protected ?string $deviceId = null;
    public readonly Properties $userProperties;
    public readonly UserPropertiesOperations $userPropertiesOperations;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $groups = null;
    protected ?string $appVersion = null;
    protected ?string $platform = null;
    protected ?string $osName = null;
    protected ?string $osVersion = null;
    protected ?string $deviceBrand = null;
    protected ?string $deviceManufacturer = null;
    protected ?string $deviceModel = null;
    protected ?string $carrier = null;
    protected ?string $country = null;
    protected ?string $region = null;
    protected ?string $city = null;
    protected ?string $dma = null;
    protected ?string $language = null;
    protected ?string $paying = null;
    protected ?string $startVersion = null;

    public function __construct()
    {
        $this->userProperties = new Properties();
        $this->userPropertiesOperations = new UserPropertiesOperations();
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function setDeviceId(?string $deviceId): self
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * @param array<string, mixed>|null $groups
     */
    public function setGroups(?array $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    public function getAppVersion(): ?string
    {
        return $this->appVersion;
    }

    public function setAppVersion(?string $appVersion): self
    {
        $this->appVersion = $appVersion;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getOsName(): ?string
    {
        return $this->osName;
    }

    public function setOsName(?string $osName): self
    {
        $this->osName = $osName;

        return $this;
    }

    public function getOsVersion(): ?string
    {
        return $this->osVersion;
    }

    public function setOsVersion(?string $osVersion): self
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    public function getDeviceBrand(): ?string
    {
        return $this->deviceBrand;
    }

    public function setDeviceBrand(?string $deviceBrand): self
    {
        $this->deviceBrand = $deviceBrand;

        return $this;
    }

    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    public function setCarrier(?string $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    public function setDeviceModel(?string $deviceModel): self
    {
        $this->deviceModel = $deviceModel;

        return $this;
    }

    public function getDeviceManufacturer(): ?string
    {
        return $this->deviceManufacturer;
    }

    public function setDeviceManufacturer(?string $deviceManufacturer): self
    {
        $this->deviceManufacturer = $deviceManufacturer;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDma(): ?string
    {
        return $this->dma;
    }

    public function setDma(?string $dma): self
    {
        $this->dma = $dma;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPaying(): ?string
    {
        return $this->paying;
    }

    public function setPaying(?string $paying): self
    {
        $this->paying = $paying;

        return $this;
    }

    public function getStartVersion(): ?string
    {
        return $this->startVersion;
    }

    public function setStartVersion(?string $startVersion): self
    {
        $this->startVersion = $startVersion;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        $properties = get_object_vars($this);

        foreach ($properties as $propertyName => $value) {
            if (is_null($value)) {
                continue;
            }

            if (in_array($propertyName, ['userPropertiesOperations', 'userProperties'])) {
                continue;
            }

            $key = $this->convertToSnakeCase($propertyName);
            $result[$key] = $value;
        }

        if (!$this->userProperties->isEmpty()) {
            $result['user_properties'] = $this->userProperties->toArray();
        } elseif (!$this->userPropertiesOperations->isEmpty()) {
            $result['user_properties'] = $this->userPropertiesOperations->toArray();
        }

        return $result;
    }

    private function convertToSnakeCase(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @throws ValidationException
     */
    public function validate(): void
    {
        if (empty($this->getUserId()) && empty($this->getDeviceId())) {
            throw new MissingRequiredPropertiesException('Either userId or deviceId is required for identification');
        }

        if (!$this->userProperties->isEmpty() && !$this->userPropertiesOperations->isEmpty()) {
            throw new ValidationException('You can\'t mix user property operations with top-level user properties');
        }
    }
}
