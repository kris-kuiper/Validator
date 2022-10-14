<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

class DefaultValue
{
    /**
     * Constructor
     */
    public function __construct(private string $fieldName, private mixed $value)
    {
    }

    /**
     * Returns the field name
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Returns the value for the field
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
