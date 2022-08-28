<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsString extends AbstractRule
{
    public const NAME = 'isString';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be of the type string';

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
        return true === is_string($this->getValue());
    }
}
