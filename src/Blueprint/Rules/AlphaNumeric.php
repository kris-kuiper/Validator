<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class AlphaNumeric extends AbstractRule
{
    public const NAME = 'alphaNumeric';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Only letters a-z, A-Z and digits 0-9 allowed';

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

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        return ctype_alnum((string) $value);
    }
}
