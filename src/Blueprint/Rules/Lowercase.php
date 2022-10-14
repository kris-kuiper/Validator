<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Lowercase extends AbstractRule
{
    public const NAME = 'lowercase';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be all lowercase characters';

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

        return mb_strtolower($value) === $value;
    }
}
