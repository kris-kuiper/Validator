<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsTrue extends AbstractRule
{
    public const NAME = 'isTrue';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Must be boolean true';

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
        return true === $this->getValue();
    }
}
