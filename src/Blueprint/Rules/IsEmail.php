<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsEmail extends AbstractRule
{
    public const NAME = 'isEmail';

    /**
     * @inheritdocs
     */
    protected string $message = 'Must be a valid email address';

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
