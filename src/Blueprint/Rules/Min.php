<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Min extends AbstractRule
{
    public const NAME = 'min';

    /**
     * @inheritdoc
     */
    protected string $message = 'Must be higher than or equal to :minimum';

    /**
     * Constructor
     */
    public function __construct(float $minimum)
    {
        parent::__construct();
        $this->setParameter('minimum', $minimum);
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
        $minimum = $this->getParameter('minimum');
        $value = $this->getValue();

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        return (float) $value >= $minimum;
    }
}
