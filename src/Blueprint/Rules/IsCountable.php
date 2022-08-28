<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsCountable extends AbstractRule
{
    public const NAME = 'isCountable';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be of the type countable';

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
        return true === is_countable($this->getValue());
    }
}
