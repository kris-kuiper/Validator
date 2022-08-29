<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsTimezone extends AbstractRule
{
    public const NAME = 'isTimezone';

    /**
     * @inheritdoc
     */
    protected string $message = 'Not a valid timezone';

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
        return true === in_array($this->getValue(), timezone_identifiers_list(), true);
    }
}
