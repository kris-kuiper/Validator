<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

abstract class AbstractRequired extends AbstractRule
{
    /**
     * @inheritdoc
     */
    protected bool $bail = true;

    /**
     * Contains the error message
     */
    protected string $message = 'Field is required';

    /**
     * Returns if a provided value is empty. A field is considered "empty" if one of the following conditions are true:
     * - The value is null.
     * - The value is an empty string.
     * - The value is an empty array or empty Countable object.
     */
    public function isEmpty(mixed $value): bool
    {
        return match (gettype($value)) {
            'array' => 0 === count($value),
            'string' => '' === $value,
            default => null === $value,
        };
    }
}
