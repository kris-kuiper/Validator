<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Blueprint\Traits\DigitsTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DigitsMin extends AbstractRule
{
    use DecimalTrait;
    use DigitsTrait;

    public const NAME = 'minDigits';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be at least :min digits long';

    /**
     * Constructor
     */
    public function __construct(private int $min)
    {
        parent::__construct();
        $this->setParameter('min', $min);
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

        if (false === is_numeric($value)) {
            return false;
        }

        if (true === $this->isDecimal($value)) {
            return false;
        }

        $length = $this->getPositiveNumberLength($value);
        return $length >= $this->min;
    }
}
