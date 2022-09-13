<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsBool extends AbstractRule
{
    public const NAME = 'isBool';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Value should be of the type boolean';

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
        return true === is_bool($this->getValue());
    }
}
