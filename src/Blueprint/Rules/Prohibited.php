<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Prohibited extends AbstractRule
{
    use EmptyTrait;

    public const NAME = 'prohibited';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid input';

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
        $fieldName = $this->getField()?->getFieldName();
        $value = $this->getValue();

        return false === array_key_exists($fieldName ?? '', $this->getValidationData()->toArray()) || true === $this->isEmpty($value);
    }
}
