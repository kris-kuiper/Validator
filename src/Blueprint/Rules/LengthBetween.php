<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class LengthBetween extends AbstractRule
{
    public const NAME = 'lengthBetween';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be between :minimum and :maximum characters long';

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

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        $length = strlen((string) $value);
        return $length >= $this->minimum && $length <= $this->maximum;
    }
}
