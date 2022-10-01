<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Events;

use KrisKuiper\Validator\Blueprint\Custom\Validation;
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

    public function field(string $fieldName): Validation
    {
        return new Validation($this->getValidationData(), $fieldName);
    }
}
