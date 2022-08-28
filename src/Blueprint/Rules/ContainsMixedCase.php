<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsMixedCase extends AbstractRule
{
    public const NAME = 'containsMixedCase';

    /**
     * @inheritdoc
     */
    protected string $message = 'Requires at least one uppercase and one lowercase letter';

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

        return true === (bool) preg_match('/[a-z]/', $value) && true === (bool) preg_match('/[A-Z]/', $value);
    }
}
