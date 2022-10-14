<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Nullable extends AbstractRule
{
    public const NAME = 'nullable';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Value may not be NULL';

    /**
     * Constructor
     */
    public function __construct(private bool $nullable = true)
    {
        parent::__construct();
        $this->setParameter('nullable', $nullable);
    }

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
        $isNull = null === $this->getValue();

        if (true === $isNull) {
            $this->getField()?->setBailed(true);
            return true === $this->nullable;
        }

        return true;
    }
}
