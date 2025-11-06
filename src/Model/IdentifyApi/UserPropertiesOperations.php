<?php

declare(strict_types=1);

namespace Readdle\AmplitudeClient\Model\IdentifyApi;

use JsonSerializable;
use Readdle\AmplitudeClient\Model\Properties;

readonly class UserPropertiesOperations implements JsonSerializable
{
    /**
     * Sets the value of a property.
     */
    public Properties $set;

    /**
     * Set the value only if the value hasn't already been set.
     */
    public Properties $setOnce;

    /**
     * Adds a numeric value to a numeric property.
     */
    public Properties $add;

    /**
     * Appends the value to a user property array.
     */
    public Properties $append;

    /**
     * Prepends the value to a user property array.
     */
    public Properties $prepend;

    /**
     * Removes a property.
     */
    public Properties $unset;

    /**
     * Adds the specified values to the beginning of the list of properties for the user property
     * if the values don't already exist in the list. Can give a single value or an array of values.
     * If a list is sent, the order of the list is maintained.
     */
    public Properties $preInsert;

    /**
     * Adds the specified values to the end of the list of properties for the user property
     * if the values don't already exist in the list. Can give a single value or an array of values.
     * If a list is sent, the order of the list is maintained.
     */
    public Properties $postInsert;

    /**
     * Removes all instances of the values specified from the list.
     * Can give a single value or an array of values.
     * These should be keys in the dictionary where the values
     * are the corresponding properties that you want to operate on.
     */
    public Properties $remove;

    public function __construct()
    {
        $this->set = new Properties();
        $this->setOnce = new Properties();
        $this->add = new Properties();
        $this->append = new Properties();
        $this->prepend = new Properties();
        $this->unset = new Properties();
        $this->preInsert = new Properties();
        $this->postInsert = new Properties();
        $this->remove = new Properties();
    }

    public function isEmpty(): bool
    {
        return $this->set->isEmpty()
            && $this->setOnce->isEmpty()
            && $this->add->isEmpty()
            && $this->append->isEmpty()
            && $this->prepend->isEmpty()
            && $this->unset->isEmpty()
            && $this->preInsert->isEmpty()
            && $this->postInsert->isEmpty()
            && $this->remove->isEmpty();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        if (!$this->set->isEmpty()) {
            $result['$set'] = $this->set->toArray();
        }

        if (!$this->setOnce->isEmpty()) {
            $result['$setOnce'] = $this->setOnce->toArray();
        }

        if (!$this->add->isEmpty()) {
            $result['$add'] = $this->add->toArray();
        }

        if (!$this->append->isEmpty()) {
            $result['$append'] = $this->append->toArray();
        }

        if (!$this->prepend->isEmpty()) {
            $result['$prepend'] = $this->prepend->toArray();
        }

        if (!$this->unset->isEmpty()) {
            $result['$unset'] = $this->unset->toArray();
        }

        if (!$this->preInsert->isEmpty()) {
            $result['$preInsert'] = $this->preInsert->toArray();
        }

        if (!$this->postInsert->isEmpty()) {
            $result['$postInsert'] = $this->postInsert->toArray();
        }

        if (!$this->remove->isEmpty()) {
            $result['$remove'] = $this->remove->toArray();
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
