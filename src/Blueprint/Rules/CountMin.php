<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Countable;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class CountMin extends AbstractRule
{
    public const NAME = 'countMin';

    /**
     * @inheritdoc
     */
    protected string $message = 'Minimum of :amount item(s)';

    /**
     * Constructor
     */
    public function __construct(int $amount)
    {
        $this->setParameter('amount', $amount);
        parent::__construct();
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
        $amount = $this->getParameter('amount');

        if (false === is_array($value) && false === $value instanceof Countable) {
            return false;
        }

        return count($value) >= $amount;
    }
}
