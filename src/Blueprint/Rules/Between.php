<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Between extends AbstractRule
{
    public const NAME = 'between';

    /**
     * @inheritdoc
     */
    protected string $message = 'Value must be between :minimum and :maximum';

    /**
     * Constructor
     */
    public function __construct(float $minimum, float $maximum)
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
        $minimum = (float) $this->getParameter('minimum');
        $maximum = (float) $this->getParameter('maximum');
        $value = $this->getValue();

        if (false === is_numeric($value)) {
            return false;
        }

        return (float)$value >= $minimum && (float)$value <= $maximum;
    }
}
