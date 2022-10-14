<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Middleware;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Fields\Field as ValidatorField;
use KrisKuiper\Validator\Translator\Path;

class Field implements MiddlewareFieldInterface
{
    /**
     * Constructor
     */
    public function __construct(private ValidatorField $field)
    {
    }

    /**
     * Returns the value of the field
     */
    public function getValue(): mixed
    {
        return $this->field->getPath()->getValue();
    }

    /**
     * Sets a new value for the field
     */
    public function setValue(mixed $value): void
    {
        $this->field->setPath(new Path($this->field->getPath()->getPath(), $value));
    }

    /**
     * Returns the name of the field
     */
    public function getFieldName(): int|string
    {
        return $this->field->getFieldName();
    }
}
