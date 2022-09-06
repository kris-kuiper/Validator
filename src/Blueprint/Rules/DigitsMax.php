<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Blueprint\Traits\DigitsTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DigitsMax extends AbstractRule
{
    use DecimalTrait;
    use DigitsTrait;

    public const NAME = 'digitsMax';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be maximum :min digits long';

    /**
     * Constructor
     */
    public function __construct(private int $max)
    {
        parent::__construct();
        $this->setParameter('max', $max);
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
            return true;
        }

        if (true === $this->isDecimal($value)) {
            return true;
        }

        $length = $this->getPositiveNumberLength($value);
        return $length <= $this->max;
    }
}
