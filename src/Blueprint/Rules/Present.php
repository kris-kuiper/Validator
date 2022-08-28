<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

class Present extends AbstractRule
{
    public const NAME = 'present';
/**
     * @inheritdoc
     */
    protected string $message = 'Invalid input';
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
        return true === array_key_exists($this->getField()?->getFieldName(), $this->getValidationData()->getData());
    }
}
