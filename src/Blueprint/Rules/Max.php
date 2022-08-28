<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Max extends AbstractRule
{
    public const NAME = 'max';

    /**
     * @inheritdoc
     */
    protected string $message = 'Must be less than or equal to :maximum';

    /**
     * Constructor
     */
    public function __construct(float $maximum)
    {
        parent::__construct();
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
        $maximum = $this->getParameter('maximum');
        $value = $this->getValue();

        if (false === is_string($value) && false === is_numeric($value)) {
            return true;
        }

        return (float) $value <= $maximum;
    }
}
