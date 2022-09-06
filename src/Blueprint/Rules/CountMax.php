<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Countable;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class CountMax extends AbstractRule
{
    public const NAME = 'countMax';

    /**
     * @inheritdoc
     */
    protected string $message = 'Maximum of :amount item(s)';

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
            return true;
        }

        return count($value) <= $this->amount;
    }
}
