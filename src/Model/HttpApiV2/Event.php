<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Model\HttpApiV2;

use JsonSerializable;
use Readdle\AmplitudeClient\Exception\MissingRequiredPropertiesException;
use Readdle\AmplitudeClient\Model\Properties;

class Event implements JsonSerializable
{
    protected ?string $userId = null;
    protected ?string $deviceId = null;
    protected ?string $eventType = null;
    protected ?int $time = null;
    public readonly Properties $eventProperties;
    public readonly Properties $userProperties;

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
    protected ?float $price = null;
    protected ?int $quantity = null;
    protected ?float $revenue = null;
    protected ?string $productId = null;
    protected ?string $revenueType = null;
    protected ?float $locationLat = null;
    protected ?float $locationLng = null;
    protected ?string $ip = null;
    protected ?string $idfa = null;
    protected ?string $idfv = null;
    protected ?string $adid = null;
    protected ?string $androidId = null;
    protected ?string $androidAppSetId = null;
    protected ?int $eventId = null;
    protected ?int $sessionId = null;
    protected ?string $insertId = null;

    public function __construct()
    {
        $this->eventProperties = new Properties();
        $this->userProperties = new Properties();
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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(?string $eventType): self
    {
        $this->eventType = $eventType;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRevenue(): ?float
    {
        return $this->revenue;
    }

    public function setRevenue(?float $revenue): self
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getRevenueType(): ?string
    {
        return $this->revenueType;
    }

    public function setRevenueType(?string $revenueType): self
    {
        $this->revenueType = $revenueType;

        return $this;
    }

    public function getLocationLat(): ?float
    {
        return $this->locationLat;
    }

    public function setLocationLat(?float $locationLat): self
    {
        $this->locationLat = $locationLat;

        return $this;
    }

    public function getLocationLng(): ?float
    {
        return $this->locationLng;
    }

    public function setLocationLng(?float $locationLng): self
    {
        $this->locationLng = $locationLng;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIdfa(): ?string
    {
        return $this->idfa;
    }

    public function setIdfa(?string $idfa): self
    {
        $this->idfa = $idfa;

        return $this;
    }

    public function getIdfv(): ?string
    {
        return $this->idfv;
    }

    public function setIdfv(?string $idfv): self
    {
        $this->idfv = $idfv;

        return $this;
    }

    public function getAdid(): ?string
    {
        return $this->adid;
    }

    public function setAdid(?string $adid): self
    {
        $this->adid = $adid;

        return $this;
    }

    public function getAndroidId(): ?string
    {
        return $this->androidId;
    }

    public function setAndroidId(?string $androidId): self
    {
        $this->androidId = $androidId;

        return $this;
    }

    public function getAndroidAppSetId(): ?string
    {
        return $this->androidAppSetId;
    }

    public function setAndroidAppSetId(?string $androidAppSetId): self
    {
        $this->androidAppSetId = $androidAppSetId;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(?int $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getSessionId(): ?int
    {
        return $this->sessionId;
    }

    public function setSessionId(?int $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getInsertId(): ?string
    {
        return $this->insertId;
    }

    public function setInsertId(?string $insertId): self
    {
        $this->insertId = $insertId;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        $excludeFromConversion = ['productId', 'revenueType'];

        $properties = get_object_vars($this);

        foreach ($properties as $propertyName => $value) {
            if (is_null($value)) {
                continue;
            }

            if (in_array($propertyName, $excludeFromConversion)) {
                $key = $propertyName;
            } else {
                $key = $this->convertToSnakeCase($propertyName);
            }

            if ($value instanceof Properties) {
                $result[$key] = $value->toArray();
            } else {
                $result[$key] = $value;
            }
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
     * @throws MissingRequiredPropertiesException
     */
    public function validate(): void
    {
        if (empty($this->getEventType())) {
            throw new MissingRequiredPropertiesException('Event Type is required for event');
        }

        if (empty($this->getUserId()) && empty($this->getDeviceId())) {
            throw new MissingRequiredPropertiesException('Either userId or deviceId is required for event');
        }
    }
}
