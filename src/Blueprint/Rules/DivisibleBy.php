<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DivisibleBy extends AbstractRule
{
    use DecimalTrait;

    public const NAME = 'divisibleBy';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Must be divisible by :number';

    /**
     * Constructor
     */
    public function __construct(float $number, bool $strict = false)
    {

        parent::__construct();
        $this->setParameter('number', $number);
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
        $number = $this->getParameter('number');

        if (false === is_numeric($value)) {
            return false;
        }

        if ((false === is_int($value) && false === is_float($value)) && true === $this->getParameter('strict')) {
            return false;
        }

        if (0.0 === $number) {
            return false;
        }

        $dividedNumber = (string) ($value / $number);

        if ('0' === $dividedNumber) {
            return false;
        }

        return false === $this->isDecimal($dividedNumber);
    }
}
