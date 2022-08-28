<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsEmpty extends AbstractRule
{
    public const NAME = 'isEmpty';

    /**
     * @inheritdoc
     */
    protected string $message = 'Field should be empty';

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
        return match (gettype($value)) {
            'array' => 0 === count($value),
            'string' => '' === $value,
            default => null === $value,
        };
    }
}
