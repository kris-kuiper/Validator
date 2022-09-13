<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsLetter extends AbstractRule
{
    public const NAME = 'containsLetter';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Requires at least one letter';

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

        return true === (bool) preg_match('/[a-zA-Z]/', $value);
    }
}
