<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

trait DigitsTrait
{
    /**
     * Returns the length of a number
     * If a negative number is provided, the number is cast to a positive number before calculating the length
     * This will exclude the "-" symbol in the length
     */
    protected function getPositiveNumberLength(string|int|float $value): int
    {
        $value = (string) $value;
        $value = ltrim($value, '-');
        return strlen($value);
    }
}
