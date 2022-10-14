<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class AlphaSpace extends AbstractRule
{
    public const NAME = 'alphaSpace';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Only letters a-z, A-Z and spaces are allowed';

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

        return (bool) preg_match('/^[a-zA-Z ]+$/', $value);
    }
}
