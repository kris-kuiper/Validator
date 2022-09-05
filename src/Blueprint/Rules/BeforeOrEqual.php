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
    protected string $message = 'Date should be before or equal to :date';
/**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(string $date, string $format = 'Y-m-d')
    {
        if (false === DateTime::createFromFormat($format, $date)) {
            throw ValidatorException::incorrectDateFormatUsed($date, $format);
        }

        parent::__construct();
        $this->setParameter('date', $date);
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

        if (true === is_string($value) || true === is_numeric($value)) {
            $format = $this->getParameter('format');
            $timestamp = DateTime::createFromFormat($format, $this->getParameter('date'))->getTimestamp();
            $date = DateTime::createFromFormat($format, (string) $value);

            if (false === $date) {
                return false;
            }

            return $date->getTimestamp() <= $timestamp;
        }

        return false;
    }
}
