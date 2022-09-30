<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class NegativeOrZero extends AbstractRule
{
    public const NAME = 'negativeOrZero';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Must be equal to zero or higher';

    /**
     * Constructor
     */
    public function __construct(bool $strict = false)
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

        if (false === is_numeric($value)) {
            return false;
        }

        if ((false === is_int($value) && false === is_float($value)) && true === $this->getParameter('strict')) {
            return false;
        }

        return $value <= 0;
    }
}
