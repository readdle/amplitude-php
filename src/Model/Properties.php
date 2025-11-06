<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Model;

use JsonSerializable;

class Properties implements JsonSerializable
{
    /**
     * @var array<string, mixed>
     */
    protected array $properties = [];

    public function set(string $key, mixed $value): self
    {
        $this->properties[$key] = $value;

        return $this;
    }

    /**
     * @param array<string, mixed> $properties
     */
    public function setArray(array $properties): self
    {
        foreach ($properties as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->properties[$key] ?? null;
    }

    public function unset(string $key): self
    {
        unset($this->properties[$key]);

        return $this;
    }

    public function reset(): self
    {
        $this->properties = [];

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->properties);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->properties;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->properties;
    }
}
