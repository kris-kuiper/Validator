<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Events;

use KrisKuiper\Validator\Collections\ErrorCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Storage\Storage;
use KrisKuiper\Validator\Translator\PathTranslator;
use KrisKuiper\Validator\ValidatedData;
use KrisKuiper\Validator\Validator;

class AfterEvent
{
    /**
     * Constructor
     */
    public function __construct(private Validator $validator, private PathTranslator $validationData)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function passed(): bool
    {
        return $this->validator->passes();
    }

    /**
     * @throws ValidatorException
     */
    public function failed(): bool
    {
        return $this->validator->fails();
    }

    public function errors(): ErrorCollection
    {
        return $this->validator->errors();
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
        return $this->validationData->toArray();
    }

    public function getValidatedData(): ValidatedData
    {
        return $this->validator->validatedData();
    }

    /**
     * Returns a storage object for storing/retrieving arbitrary data
     */
    public function storage(): Storage
    {
        return $this->validator->storage();
    }
}
