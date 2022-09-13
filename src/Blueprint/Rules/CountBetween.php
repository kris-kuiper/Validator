<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Countable;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class CountBetween extends AbstractRule
{
    public const NAME = 'countBetween';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Amount of items should be between :minimum and :maximum';

    /**
     * Constructor
     */
    public function __construct(private int $minimum, private int $maximum)
    {
        parent::__construct();
        $this->setParameter('minimum', $minimum);
        $this->setParameter('maximum', $maximum);
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

        if (false === is_array($value) && false === $value instanceof Countable) {
            return false;
        }

        $amount = count($value);
        return $amount >= $this->minimum && $amount <= $this->maximum;
    }
}
