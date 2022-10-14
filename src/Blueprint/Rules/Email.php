<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Email extends AbstractRule
{
    public const NAME = 'email';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Must be a valid email address';

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

        if (true === is_string($value)) {
            return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        return false;
    }
}
