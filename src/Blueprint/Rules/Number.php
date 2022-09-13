<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Number extends AbstractRule
{
    public const NAME = 'number';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Value must be a number';

    /**
     * Constructor
     */
    public function __construct(private bool $strict = false)
    {
        parent::__construct();
        $this->setParameter('strict', $strict);
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
        $value = $this->getValue();

        if (true === is_string($value) || is_numeric($value)) {
            if (true === $this->strict) {
                return true === is_numeric($value) && false === is_string($value);
            }

            return (bool) preg_match('/^-?\d+(\.?\d*(e\+)?\d+)?$/i', (string) $value);
        }

        return false;
    }
}
