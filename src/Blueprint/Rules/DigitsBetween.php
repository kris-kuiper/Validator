<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Blueprint\Traits\DigitsTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DigitsBetween extends AbstractRule
{
    use DecimalTrait;
    use DigitsTrait;

    public const NAME = 'digitsBetween';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be between :min and :max digits long';

    /**
     * Constructor
     */
    public function __construct(int $min, int $max)
    {
        parent::__construct();
        $this->setParameter('min', $min);
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
            return false;
        }

        if (true === $this->isDecimal($value)) {
            return false;
        }

        $length = $this->getPositiveNumberLength($value);
        return $length >= $this->getParameter('min') && $length <= $this->getParameter('max');
    }
}
