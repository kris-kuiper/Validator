<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use DateTime;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class BeforeOrEqual extends AbstractRule
{
    public const NAME = 'beforeOrEqual';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Date should be before or equal to :date';

    /**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(private string $date, private string $format = 'Y-m-d')
    {
        if (false === DateTime::createFromFormat($format, $date)) {
            throw ValidatorException::incorrectDateFormatUsed($date, $format);
        }

        parent::__construct();

        $this->setParameter('date', $this->date);
        $this->setParameter('format', $this->format);
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

        if (true === is_string($value) || true === is_numeric($value)) {
            $timestamp = DateTime::createFromFormat($this->format, $this->date)->getTimestamp();
            $date = DateTime::createFromFormat($this->format, (string) $value);

            if (false === $date) {
                return false;
            }

            return $date->getTimestamp() <= $timestamp;
        }

        return false;
    }
}
