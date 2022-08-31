<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsNotNull extends AbstractRule
{
    public const NAME = 'isNotNull';

    /**
     * @inheritdoc
     */
    protected string $message = 'Must not be null';

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
        return null !== $this->getValue();
    }
}
