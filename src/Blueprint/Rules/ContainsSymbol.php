<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsSymbol extends AbstractRule
{
    public const NAME = 'containsSymbol';

    /**
     * @inheritdoc
     */
    protected string $message = 'Requires at least one symbol';

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

        return true === (bool) preg_match('/[\W_]+/', preg_replace('/\s+/', '', (string) $value));
    }
}
