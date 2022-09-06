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
    public function __construct(private float $minimum, private float $maximum)
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

        if (false === is_numeric($value)) {
            return false;
        }

        return (float) $value >= $this->minimum && (float) $value <= $this->maximum;
    }
}
