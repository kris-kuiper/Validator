<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsNumber extends AbstractRule
{
    public const NAME = 'containsNumber';

    /**
     * @inheritdoc
     */
    protected string $message = 'Requires at least one number';

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

        return true === (bool) preg_match('/\d/', (string) $value);
    }
}
