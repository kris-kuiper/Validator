<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\DateTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Date extends AbstractRule
{
    use DateTrait;

    public const NAME = 'date';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Must be a valid date in ":format" format';

    /**
     * Constructor
     */
    public function __construct(private string $format = 'Y-m-d')
    {
        parent::__construct();
        $this->setParameter('format', $format);
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

        try {
            $this->createDate((string) $value, $this->format);
        } catch (ValidatorException) {
            return false;
        }

        return true;
    }
}
