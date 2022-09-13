<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Distinct extends AbstractRule
{
    public const NAME = 'distinct';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'May not contain duplicate values';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $value = $this->getValue();

        if (true === is_array($value)) {
            return count($value) === count(array_unique(array_values($value)));
        }

        return true;
    }
}
