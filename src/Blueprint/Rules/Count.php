<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Countable;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Count extends AbstractRule
{
    public const NAME = 'count';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Must contain :amount item(s)';

    /**
     * Constructor
     */
    public function __construct(private int $amount)
    {
        parent::__construct();
        $this->setParameter('amount', $amount);
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

        return count($value) === $this->amount;
    }
}
