<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class AlphaDash extends AbstractRule
{
    public const NAME = 'alphaDash';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Only letters a-z, A-Z, digits 0-9, dashes and underscores allowed';

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

        return (bool) preg_match('/^[a-zA-Z_\-]+$/', (string) $value);
    }
}
