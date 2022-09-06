<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use DateTime;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Date extends AbstractRule
{
    public const NAME = 'date';

    /**
     * @inheritdoc
     */
    protected string $message = 'Must be a valid date';

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

        $date = DateTime::createFromFormat($this->format, (string) $value);
        return false !== $date && $date->format($this->format) === $value;
    }
}
