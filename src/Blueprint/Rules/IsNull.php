<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsNull extends AbstractRule
{
    public const NAME = 'isNull';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Must be null';

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
        return null === $this->getValue();
    }
}
