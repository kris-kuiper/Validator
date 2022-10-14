<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Hexadecimal extends AbstractRule
{
    public const NAME = 'hexadecimal';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be a valid hexadecimal value';

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

        if (false === is_string($value)) {
            return false;
        }

        return true === ctype_xdigit($value);
    }
}
