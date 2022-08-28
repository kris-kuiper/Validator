<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Contracts;

interface MiddlewareFieldInterface
{
    /**
     * Returns the value of the field under validation
     */
    public function getValue(): mixed;

    /**
     * Sets a new value for the field under validation
     */
    public function setValue(mixed $value): void;

    /**
     * Returns the name of the field under validation
     */
    public function getFieldName(): string;

    /**
     * Bails the next rule, preventing from executing next validation rules
     */
    public function bail(): void;
}
