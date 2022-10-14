<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Equals extends AbstractRule
{
    public const NAME = 'equals';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Input should match :value';

    /**
     * Constructor
     */
    public function __construct(private mixed $value, private bool $strict = false)
    {
        parent::__construct();
        $this->setParameter('value', $value);
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

        //Check if strict mode is active
        if (true === $this->strict) {
            //Compare the two types
            if (gettype($value) !== gettype($this->value)) {
                return false;
            }

            //Compare strictly
            return $value === $this->value;
        }

        //Compare but not strictly
        // @codingStandardsIgnoreStart
        return $value == $this->value;
        // @codingStandardsIgnoreEnd
    }
}
