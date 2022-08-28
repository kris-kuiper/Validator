<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

trait DecimalTrait
{
    /**
     * Returns if a provided value is a number with a decimal
     */
    protected function isDecimal(string|int|float $value): bool
    {
        return (bool) preg_match('/^-?\d+\.\d+$/', (string) $value);
    }
}
