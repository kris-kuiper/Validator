<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Events;

use KrisKuiper\Validator\Blueprint\Custom\Validation;
use KrisKuiper\Validator\FieldFilter;
use KrisKuiper\Validator\Storage\Storage;
use KrisKuiper\Validator\Translator\PathTranslator;

class BeforeEvent
{
    /**
     * Constructor
     */
    public function __construct(private PathTranslator $validationData, private Storage $storage)
    {
    }

    /**
     * Returns the value of a given field name
     */
    public function getValue(string $fieldName): mixed
    {
        return $this->validationData->path($fieldName)->getValue();
    }

    /**
     * Returns the data under validation as an array
     */
    public function getValidationData(): array
    {
        return $this->validationData->getData();
    }

    /**
     * Returns a storage object for storing/retrieving arbitrary data
     */
    public function storage(): Storage
    {
        return $this->storage;
    }

    /**
     * Validates the provided field name against validation rules
     */
    public function field(string $fieldName): Validation
    {
        return new Validation($this->getValidationData(), $fieldName);
    }

    /**
     * Filters values based on a field name and provided validation rules
     * Use FILTER_MODE_PASSED to only include values that pass the validation rules
     * Use FILTER_MODE_FAILED to only include values that fail the validation rules
     */
    public function filter(string|int|float $fieldName, int $filterMode = FieldFilter::FILTER_MODE_PASSED): FieldFilter
    {
        return new FieldFilter($this->validationData, $fieldName, $filterMode);
    }
}
