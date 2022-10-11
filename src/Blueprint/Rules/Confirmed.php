<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

class Confirmed extends AbstractRule
{
    public const NAME = 'confirmed';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Not correctly confirmed';

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
        $validationData = $this->getValidationData()->toArray();
        return true === array_key_exists(((string) $this->getField()?->getFieldName()) . '_confirmed', $validationData);
    }
}
