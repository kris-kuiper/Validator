<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsFalse extends AbstractRule
{
    public const NAME = 'isFalse';

    /**
     * @inheritdocs
     */
    protected string $message = 'Must be boolean false';

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
        return false === $this->getValue();
    }
}
