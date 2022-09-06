<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class UUIDv4 extends AbstractRule
{
    public const NAME = 'uuidv4';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be a valid v4 UUID string';

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

        return true === (bool) preg_match('/^[\dA-F]{8}-[\dA-F]{4}-4[\dA-F]{3}-[89AB][\dA-F]{3}-[\dA-F]{12}$/i', (string) $value);
    }
}
