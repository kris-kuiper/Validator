<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

class Present extends AbstractRule
{
    public const NAME = 'present';

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
     */
    public function isValid(): bool
    {
        $fieldName = $this->getField()?->getFieldName();
        return true === array_key_exists($fieldName ?? '', $this->getValidationData()->getData());
    }
}
