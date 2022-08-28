<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsAlpha extends AbstractRule
{
    public const NAME = 'isAlpha';

    /**
     * @inheritdocs
     */
    protected string $message = 'Only letters allowed (a-z, A-Z)';

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

        return (bool) preg_match('/^[a-zA-Z]+$/', (string) $value);
    }
}
